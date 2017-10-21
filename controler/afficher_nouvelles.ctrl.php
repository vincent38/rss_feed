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
        $alert['message'] = "RSS_ID invalide !";
        $alert['type'] = "danger";
        $alert['icon'] = "pe-7s-attention";
    }

    require_once "../view_style/afficher_nouvelles.view.php";
}