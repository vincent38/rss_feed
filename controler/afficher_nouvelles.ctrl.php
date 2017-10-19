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

    foreach ($dao->getAllNews($rssID) as $new) {
        /* On forme l'URL vers l'affichage de la nouvelle unique */
        $new->urlParsed = "afficher_nouvelle.ctrl.php?newID=".$new->id()."&rssID=".$rssID;

        /* On ajoute le titre du flux contenant dans l'objet new */
        $new->RSStitre = $dao->readRSSfromID($rssID)->titre();

        /* On ajoute l'objet NEW dans l'array data */
        $data[] = $new;
    }

    include "../view_style/afficher_nouvelles.view.php";
}