<?php

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();
 
/* Variable globale data contenant les données passées à la vue */
$data = array();

foreach ($dao->getRSSFlux() as $rss) {
    /* On ajoute l'objet RSS dans l'array data */
    $rss->date = date('r', $rss->date);
    $data[] = $rss;
}

// Vue
include "../view/see_all.view.php";