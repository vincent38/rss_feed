<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();
 
/* Variable globale data contenant les données passées à la vue */
$data = array();
$noFlux = true;

$allFlux = $dao->getRSSFlux();

if ($allFlux !== null) {
    foreach ($allFlux as $rss) {
        /* On ajoute l'objet RSS dans l'array data */
        $rss->date = date("d/m/Y H:i", $rss->date); // On convertit le timestamp en français
        $data[] = $rss;
        $noFlux = false;
    }
}

require_once "../view_style/afficher_flux.view.php";