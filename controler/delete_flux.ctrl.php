<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

if (isset($_POST['toDelete'])) {
    //reçu urls
    $alert['message'] = "Les flux suivants ont été supprimés : <br>";
    foreach ($_POST['toDelete'] as $url) {
        //Update 1 par 1
        $rss = $dao->readRSSfromURL($url);
        $rss->delete();
        $alert['message'] .= $rss->titre."<br>";
    }
}

/* Variable globale data contenant les données passées à la vue */
$data = array();
$allFlux = $dao->getRSSFlux();

if ($allFlux !== null) {
    foreach ($dao->getRSSFlux() as $rss) {
    /* On ajoute l'objet RSS dans l'array data */
    $data[] = $rss;
    }
}

// Vue
include "../view/delete_flux.view.php";
