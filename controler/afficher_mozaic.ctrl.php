<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

/* Si aucun rssID n'est passé en GET, on prend -1 */
$rssID = $_POST['rssID'] ?? -1;

/* Variable globale data contenant les images des nouvelles du flux RSS */
$all_news = $dao->getAllNews($rssID);

/* On initialise les éléments passés à la vue */
$data = array();
$data_new = array();

/* Tableau contenant tous les codes couleur bootstrap */
$allCodes = array ("btn-success", "btn-info", "btn-warning", "btn-danger", "btn-default");

if ($all_news !== null) {

    /* On formate les objets nouvelle passés à la vue */
    foreach ($all_news as $nouvelle) {
        $rssObj = $dao->readRSSfromID($nouvelle->RSS_id());

        if ($nouvelle -> urlImage() === null) {
            $nouvelle->realImg = "../data/no_img.png";            
        } else {
            $nouvelle->realImg = $nouvelle->urlImage();
        }
        
        /* On ajoute le titre du flux contenant dans l'objet new */
        $nouvelle->RSStitre = $rssObj->titre();

        $data_new[] = $nouvelle;
    }

    /* On formate les éléments de flux envoyés à la vue */
    $allRSS = $dao->getRSSFlux();
    $data_rss = array();

    $i = 0;

    foreach ($allRSS as $rss) {
        $data_rss[] = array("nom" => $rss->titre(), "icon" => $allCodes[$i % 5], "id" => $rss->id);
        $i++;
    }

    $data['news'] = $data_new;
    $data['flux'] = $data_rss;
    $data['selectedID'] = $all_news[0]->RSS_id();

    require_once "../view_style/afficher_mozaic.view.php";
}