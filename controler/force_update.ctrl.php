<?php
/* MISE A JOUR DU CONTENU D'UN FLUX (IMAGES, NOUVELLES) */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

if (!empty($_POST['toUpdate'])) {
    //reçu urls
    $alert['message'] = "Les flux suivants ont été mis à jour : <br>";
    foreach ($_POST['toUpdate'] as $url) {
        // Traitement des données reçues en POST
        $dub = explode ('|', $url);

        // Update des flux un par un
        $rss = $dao->readRSSfromID($dub[0]);
        $rss->update();

        $alert['message'] .= "<b>".$dub[1]."</b><br>";
    }

    $alert['type'] = "success";
    $alert['icon'] = "pe-7s-check";
}

/* Variable globale data contenant les données passées à la vue */
$data = array();
$allFlux = $dao->getRSSFlux();

if ($allFlux) {
    $data = $allFlux;
} else { // On affiche un message d'erreurs
    $noResult['type'] = 'Aucun flux';
    $noResult['message'] = '<p class="special-subtext">Vous n\'avez enregistré aucun flux ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}

// Vue
include "../view_style/force_update.view.php";