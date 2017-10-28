<?php
/* VUE D'AJOUT DE FLUX */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

// Includes principaux
require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

// Déclaration de la variable contenant les messages d'erreur
$alert = array();

if (!empty($_POST['url']) and !empty($_POST['titre'])) {
    //OK, on échappe le titre et on fait les vérifs
    $titre = htmlspecialchars($_POST['titre']);

    $url = htmlspecialchars($_POST['url']);

    //if (filter_var($url, FILTER_VALIDATE_URL)) {
    // précédemment, filter_var était utilisé, mais cette méthode bloquait des URLs pourtant valides, comme :
    // http://www.courrierinternational.com/feed/all/rss.xml
    // On utilisera donc une expression régulière provenant du site codekarate.com
    if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {        
        //URL valide
        $rss = $dao->readRSSfromURL($url);
        if ($rss == NULL) {
            //URL Inconnue, on ajoute
            $rss = $dao->createRSS($url, $titre);
            $rss->update();

            $alert['message'] = "Flux ajouté !";
            $alert['type'] = "success";
            $alert['icon'] = "pe-7s-check";
            // type = ['','info','success','warning','danger'];
            // icones : pe-7s-check, pe-7s-close-circle,  pe-7s-attention
        } else {
            $alert['message'] = "Flux déjà présent en BDD !";
            $alert['type'] = "warning";
            $alert['icon'] = "pe-7s-close-circle";
        }
    } else {
        $alert['message'] = "URL invalide !";
        $alert['type'] = "danger";
        $alert['icon'] = "pe-7s-attention";
    }
}

// Vue
require_once "../view_style/add_flux.view.php";