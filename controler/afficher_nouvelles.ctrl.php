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
        /* On ajoute l'objet NEW dans l'array data */
        $data[] = $new;
    }

    include "../view/afficher_nouvelles.view.php";
}