<?php

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

var_dump($_POST);
if (isset($_POST['flux'])) {
    // On récupère l'array des id des flux à vider
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