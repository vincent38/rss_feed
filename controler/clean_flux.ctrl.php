<?php

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

var_dump($_POST);

if ($_POST !== null) {
    $dao = new DAO();

    $alert['message'] = "Les flux suivants ont été purgés : <br>";
    foreach ($_POST as $rssData) {
        $rssID = explode("|", $rssData);
        $dao->purgeRSSFlux($rssID[0]); 
        $alert['message'] .= $rssID[1]."<br>";
    }
} 

// Listing des flux

$dao = new DAO();

/* Variable globale data contenant les données passées à la vue */
$data = array();
$allFlux = $dao->getRSSFlux();

foreach ($allFlux as $rss) {
   /* On ajoute l'objet RSS dans l'array data */
   $data[] = $rss;
}

// Vue
include "../view/clean_flux.view.php";