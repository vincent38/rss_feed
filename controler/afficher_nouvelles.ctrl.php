<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

/* Si le champ "rssID" est défini */
if (isset($_GET['rssID'])) {
    $rssID = $_GET['rssID'];

    /* Variable globale data contenant les données passées à la vue */
    $data = array();

    $allNews = $dao->getAllNews($rssID);

    if ($allNews) {
        foreach ($allNews as $new) {
            /* On ajoute le titre du flux contenant dans l'objet new */
            $new->RSStitre = $dao->readRSSfromID($new->RSS_id())->titre();

            /* On ajoute l'objet NEW dans l'array data */
            $data[] = $new;
        }
    } else {
        /* On vérifie que le RSS_id existe */
        $rssObj = $dao->readRSSfromID($rssID);

        /* Si l'objet RSS existe, on affiche un message signifiant que le flux est vide */
        if ($rssObj) {
            $noResult['type'] = "Flux vide";
            $noResult['message'] = '<p class="special-subtext">Rien à afficher ! Ce flux est vide... <a href = "afficher_flux.ctrl.php">Retourner à la liste des flux</a></p>';        
        } else { // Sinon c'est une erreur
            $noResult['type'] = "RSS_ID incorrect";
            $noResult['message'] = '<p class="special-subtext">Ce flux RSS n\'existe pas. <a href = "afficher_flux.ctrl.php">Retourner à la liste des flux</a></p>';
        }
    }

    require_once "../view_style/afficher_nouvelles.view.php";
} else {
    // S'il n'y a pas de paramètre rssID, on redirige vers l'accueil
    header("Location: ../index.php");

    // On arrête le script PHP
    exit();
}