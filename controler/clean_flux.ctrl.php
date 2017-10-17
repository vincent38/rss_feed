<?php
//Are u logged in ?
session_start();
if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
    //Goodbye
    header("Location: afficher_flux.ctrl.php");
}

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

if (isset($_POST['toClean'])) {
    $dao = new DAO();

    $alert['message'] = "Les flux suivants ont été purgés : <br>";
    foreach ($_POST['toClean'] as $rssData) {
        $rssID = explode("|", $rssData);
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
