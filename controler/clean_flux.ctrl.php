<?php

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

if (!empty($_POST['toClean'])) {
    $dao = new DAO();

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

// Listing des flux
$dao = new DAO();

/* Variable globale data contenant les données passées à la vue */
$data = array();
$allFlux = $dao->getRSSFlux();

if ($allFlux !== null) {
    foreach ($allFlux as $rss) {
    /* On ajoute l'objet RSS dans l'array data */
    $data[] = $rss;
    }
}

// Vue
include "../view_style/clean_flux.view.php";
