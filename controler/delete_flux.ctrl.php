<?php
//Are u logged in ?
session_start();
if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
    //Goodbye
    header("Location: signin.ctrl.php");
}

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

if (isset($_POST['toDelete'])) {
    $alert['message'] = "Les flux suivants ont été supprimés : <br>";
    
    foreach ($_POST['toDelete'] as $rssID) {
        //Update 1 par 1
        $rss = $dao->readRSSfromID($rssID);
        $rss->delete();

        $alert['message'] .= "<b>".$rss->titre."</b><br>";
    }
    
    $alert['type'] = "success";
    $alert['icon'] = "pe-7s-check";
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
include "../view_style/delete_flux.view.php";
