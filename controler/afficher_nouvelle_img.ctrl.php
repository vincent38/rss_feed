<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

$rssID =  $_GET['rssID'];

/* Variable globale data contenant les images des nouvelles du flux RSS */
$all_news = $dao->getAllNews($rssID);
$data = array();

if ($all_news !== null) {
    foreach ($all_news as $nouvelle) {
        if ($nouvelle -> urlImage() === null) {
            $img = "../data/no_img.svg";
        } else {
            $img = $nouvelle->urlImage();
        }
        $data[] = array ($img, "afficher_nouvelle.ctrl.php?newID=".$nouvelle->id()."&rssID=".$rssID);
    }

    include "../view/afficher_nouvelles_img.view.php";
}