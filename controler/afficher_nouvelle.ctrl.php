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

    include "../view_style/afficher_nouvelle.view.php";
}