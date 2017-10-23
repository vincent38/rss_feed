<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

/* Si le champ "rssID" est défini */
if (isset($_GET['newID']) and isset( $_GET['rssID'])) {
    $newID = $_GET['newID'];
    $rssID =  $_GET['rssID'];

    /* Variable globale data contenant les données passées à la vue */
    $data = $dao->readNouvellefromID($newID, $rssID);

    // Si la requête a envoyé quelque chose    
    if ($data) {
        /* On ajoute le titre du flux contenant dans l'objet data */
        $data->RSStitre = $dao->readRSSfromID($rssID)->titre();

        /* On formate un titre "raccourci" à faire apparaître dans la navigation 
        => on récupère les cinq premiers groupes délimités par des espaces */
        $tdub = $data->titre();
        $sdub = explode(" ", $tdub);

        $short_titre = "";

        for ($i=0; $i<5; $i++) {
            $short_titre .= " ".$sdub[$i];
        }
        
        $short_titre .= "...";

        $data->new_titre = $short_titre;
        /* ================================================================= */

    } else { // On affiche un message d'erreur approprié
        $noResult['type'] = "Aucun résultat";
        $noResult['message'] = '<p class="special-subtext">Rien à afficher ! Paramètres incorrects... <a href="afficher_flux.ctrl.php">Liste des flux</a></p>';
    }

    require_once "../view_style/afficher_nouvelle.view.php";
} else {
    // S'il n'y a pas de paramètre rssID, on redirige vers l'accueil
    header("Location: ../index.php");

    // On arrête le script PHP
    exit();
}