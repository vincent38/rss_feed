<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

/* Si le champ "rssID" est défini */
if (isset($_GET['nouvelleTitle']) and isset( $_GET['rssID'])) {
    $nouvelleTitle = $_GET['nouvelleTitle'];
    $rssID =  $_GET['rssID'];

    /* Variable globale data contenant les données passées à la vue */

    $data = $dao->readNouvellefromTitre($nouvelleTitle, $rssID);

    include "../view/afficher_nouvelle.view.php";
}