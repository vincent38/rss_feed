<?php
/* SUPPRESSION TOTALE D'UN FLUX */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

if (!empty($_POST['toDelete'])) {
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

if ($allFlux) {
    $data = $allFlux;
} else { // On affiche un message d'erreur
    $noResult['type'] = 'Aucun flux';
    $noResult['message'] = '<p class="special-subtext">Vous n\'avez enregistré aucun flux ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}

// Vue
include "../view_style/delete_flux.view.php";
