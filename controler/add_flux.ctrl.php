<?php
//Are u logged in ?
session_start();
if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
    //Goodbye
    header("Location: afficher_flux.ctrl.php");
}

// Ajout flux

require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

if (isset($_POST['url']) and isset($_POST['titre'])) {
    //OK, on échappe et on fait les vérifs
    $titre = htmlspecialchars($_POST['titre']);
    $url = htmlspecialchars($_POST['url']);
    $dao = new DAO();
    
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        //URL valide
        $rss = $dao->readRSSfromURL($url);
        if ($rss == NULL) {
            //URL Inconnue, on ajoute
            $rss = $dao->createRSS($url, $titre);
            $rss->update();
            $alert['message'] = "Flux ajouté !";
        } else {
            $alert['message'] = "Flux déjà présent en BDD !";
        }
    } else {
        $alert['message'] = "URL invalide !";
    }
}


// Vue
include "../view/add_flux.view.php";