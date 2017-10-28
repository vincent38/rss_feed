<?php
/* AFFICHAGE DE LA LISTE DES ABONNEMENTS D'UN UTILISATEUR, TRIÉE PAR CATÉGORIES */

// Vérification de l'authentification
require_once('redirect.ctrl.php');
require_once("../model/RSS.class.php");
require_once("../model/DAO.class.php");

// Déclaration de la variable contenant les messages d'erreur
$alert = array();

/* Récupération de l'objet utilisateur à partir de la variable de session */
$current_user = $_SESSION["user"];

/* Si l'utilisateur veut se désabonner d'un flux */
if (!empty($_POST['unsub'])) {
    $rssID = $_POST['unsub'];
    $rssName = $dao->readRSSfromID($rssID)->titre();

    $result = $dao->unsubscribe($current_user->getLogin(), $rssID);

    // Si le désabonnement a été réalisé correctement
    if ($result) {
        $alert['message'] = "Vous n\'êtes plus abonné au flux : <br><b>".$rssName."</b></br>";
        $alert['type'] = "success";
        $alert['icon'] = "pe-7s-check";
    } else {
        $alert['message'] = "Action impossible : vous n\'êtes pas abonné à ce flux";
        $alert['type'] = "warning";
        $alert['icon'] = "pe-7s-close-circle";
    }
}

$data = array();

/* On recherche tous les abonnements de l'utilisateur et on les stocke dans la variable $data */
$data = $dao->getAbo($current_user->getLogin());

/* Si l'utilisateur n'a aucun abonnements, on affiche un message d'erreur */
if (!$data) {
    $noResult = array(); $noResult['type'] = 'Aucun abonnement';
    $noResult['message'] = '<p class="special-subtext">Vous n\'êtes abonné à aucun flux ! <a href="manage_subs.ctrl.php">Créer un abonnement</a></p>';   
}

require_once "../view_style/afficher_subs.view.php";