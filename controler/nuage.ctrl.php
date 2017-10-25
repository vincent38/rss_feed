<?php
/* AFFICHAGE D'UN NUAGE DE MOTS PRESENTANT L'ACTUALITE */

// Vérification de l'authentification
require_once('redirect.ctrl.php');
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');
 
/* Variable globale data contenant les données passées à la vue */
$data = array();

$allFlux = $dao->getRSSFlux();

if ($allFlux) {
    // On récupère les mots les plus fréquents des cinq derniers jours et on fait des traitements dessus
    $words = $dao->getAllWords(5);

} else { // Si aucun flux n'est enregistré
    $noResult['type'] = 'Aucun flux';
    $noResult['message'] = '<p class="special-subtext">Vous n\'avez enregistré aucun flux ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}

require_once "../view_style/nuage.view.php";