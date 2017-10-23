<?php
/* SUPPRESSION DU CONTENU DES FLUX (IMAGES, NOUVELLES) */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

if (!empty($_POST['toClean'])) {
    $alert['message'] = "Les flux suivants ont été purgés : <br>";
    foreach ($_POST['toClean'] as $rssData) {
        // On traite la chaîne passée en POST
        $rssID = explode("|", $rssData);

        // On récupère l'objet RSS et on supprime les images qui lui sont associées
        $rssObj = $dao->readRSSfromID($rssID[0]);
        $rssObj->deleteImg();

        // On supprime toutes les nouvelles associées au flux RSS
        $dao->purgeRSSFlux($rssID[0]);

        $alert['message'] .= "<b>".$rssID[1]."</b><br>";
    }

    $alert['type'] = "success";
    $alert['icon'] = "pe-7s-check";
}

/* Variable globale data contenant les données passées à la vue */
$data = array();
$allFlux = $dao->getRSSFlux();

if ($allFlux) {
    $data = $allFlux;
} else {
    $noResult['type'] = 'Aucun flux';
    $noResult['message'] = '<p class="special-subtext">Vous n\'avez enregistré aucun flux ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}

// Vue
include "../view_style/clean_flux.view.php";
