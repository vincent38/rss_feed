<?php
/* AFFICHAGE D'UN NUAGE DE MOTS PRESENTANT L'ACTUALITE */

// Vérification de l'authentification
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');
 
/* Variable globale data contenant les données passées à la vue */
$data = array();

$allFlux = $dao->getRSSFlux();

if ($allFlux) {
    $nbMots = 30;

    // On récupère les 30 mots les plus fréquents des 10 derniers jours, triés par fréquence
    $words = $dao->getAllWords(10, $nbMots);

    if ($words) {
        // On calcule les polices via un ratio par rapport au mot le plus fréquent
        // On attribue des couleurs à chaque mot
        $max_occ = array_values($words)[0];
        $color_set = array("ea3e21", "66003e", "2a6f00", "eaac39", "6a6208", "ebf853", "3b250e", "465124", "cd001f", "c9f044", "e1ad65", "b67ab3");
        $i = 0;

        foreach ($words as $word => $nb) {
            $coul = $color_set[$i%12];

            // On calcule la taille => déduite du nombre d'occurences et de l'ordre d'apparition dans la liste
            $size = (int)(($nb/$max_occ) * 60 + (($nbMots - $i)/$nbMots) * 10);

            $data[] = array ("txt" => $word, "coul" => $coul, "taille" => $size);

            $i++;
        }

    } else { // S'il n'y a aucun mot reçu
        $noResult = array(); $noResult['type'] = "Rien à voir";
        $noResult['message'] = '<p class="special-subtext">Rien de neuf ici pour les cinq derniers jours... <a href="force_update.ctrl.php">Mettre à jour les flux</a></p>';  
    }

} else { // Si aucun flux n'est enregistré
    $noResult = array(); $noResult['type'] = 'Aucun flux';
    $noResult['message'] = '<p class="special-subtext">Vous n\'avez enregistré aucun flux ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}

require_once "../view_style/today.view.php";