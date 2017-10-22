<?php

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

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

if ($allFlux !== null) {
    foreach ($allFlux as $rss) {
        /* On ajoute l'objet RSS dans l'array data */
        $data[] = $rss;
    }
}

// Vue
include "../view_style/force_update.view.php";