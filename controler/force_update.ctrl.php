<?php

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

if (isset($_POST['toUpdate'])) {
    //reçu urls
    $alert['message'] = "Les flux suivants ont été mis à jour : <br>";
    foreach ($_POST['toUpdate'] as $url) {
        //Update 1 par 1
        $rss = $dao->readRSSfromURL($url);
        $rss->update();
        $alert['message'] .= $rss->titre."<br>";
    }
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
include "../view/force_update.view.php";