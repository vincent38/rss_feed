<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();
$resuts = false;
var_dump($_POST);

if (isset($_POST['searchstr'])) {
    //reçu urls
    $s_str = $_POST['searchstr'];
    $strict = ($_POST['typeS'] == "anyT");
    $time = $_POST['time'];

    /* Variable globale data contenant les données passées à la vue */
    $data = array();

    $foundNews = $dao->searchNews ($s_str, $strict, $time);

    echo $s_str;
}

/* Variable globale data contenant les données passées à la vue */
$data = array();
/*
$allFlux = $dao->getRSSFlux();

if ($allFlux !== null) {
    foreach ($dao->getRSSFlux() as $rss) {
    /* On ajoute l'objet RSS dans l'array data */
    /*$data[] = $rss;
    }
}
*/

// Vue
include "../view/search.view.php";
