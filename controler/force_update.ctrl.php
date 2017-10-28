<?php
/* MISE A JOUR DU CONTENU D'UN FLUX (IMAGES, NOUVELLES) */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

// Déclaration de la variable contenant les messages utilisateur
$alert = array();

if (!empty($_POST['toUpdate'])) {
    //reçu urls
    $alert['message'] = "Les flux suivants ont été mis à jour avec succès : <br>";    
    $alert['type'] = "success";
    $alert['icon'] = "pe-7s-check";

    // Flags de statut
    $warning = false; $totalFail = true;

    foreach ($_POST['toUpdate'] as $url) {
        // Traitement des données reçues en POST
        $dub = explode ('|', $url);

        // Update des flux un par un
        $rss = $dao->readRSSfromID($dub[0]);
        $state = $rss->update();

        // Si la mise à jour a fonctionné, on ajoute le flux à la liste
        if ($state) {
            $alert['message'] .= "<b>".$dub[1]."</b><br>";
            $totalFail = false;
        } else {
            $warning = true;
        }
    }

    if ($warning) {
        if ($totalFail) {
            $alert['message'] = "Erreur : aucun flux n\'a pu être mis à jour.";
            $alert['type'] = "warning";
            $alert['icon'] = "pe-7s-close-circle";
        } else {
            $alert['message'] .= "Certains flux n\'ont pas pu être mis à jour.";
        }
    }
}

/* Variable globale data contenant les données passées à la vue */
$data = array();
$allFlux = $dao->getRSSFlux();

if ($allFlux) {
    $data = $allFlux;
} else { // On affiche un message d'erreurs
    $noResult = array(); $noResult['type'] = 'Aucun flux';
    $noResult['message'] = '<p class="special-subtext">Vous n\'avez enregistré aucun flux ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}

// Vue
require_once "../view_style/force_update.view.php";