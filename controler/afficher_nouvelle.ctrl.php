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

    include "../view_style/afficher_nouvelle.view.php";
}