<?php
/* AFFICHAGE DE L'ESPACE DISQUE OCCUPE PAR CHAQUE FLUX */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

// Ajout flux
require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

$data = array();

// On récupère les statistiques en matière de données stockées
$stats = $dao->getRSS_size();

if ($stats) {
    // Colorset à utiliser pour le graphe
    $color_set = array ("255, 99, 132", "54, 162, 235", "255, 205, 86", "255, 11, 105", "255, 204, 92", "136, 216, 176");

    $data['labels'] = "";
    $data['stats'] = "";
    $data['colors'] = "";

    $i = 0;

    // On ajoute les statistiques à l'objet $data
    foreach ($stats as $nomRSS => $taille) {
        $data['labels'].= ',"'.$nomRSS. '"';
        $data['stats'] .=  ','.$taille;
        $data['colors'] .= ', "rgb('.$color_set[$i%7].')"';

        $i++;
    }

    // On enlève la première virgule des chaînes
    $data['labels'] = substr($data['labels'], 1);
    $data['stats'] = substr($data['stats'], 1);
    $data['colors'] = substr($data['colors'], 1);

} else {
    $noResult = array(); $noResult['type'] = 'Aucune image stockée';
    $noResult['message'] = '<p class="special-subtext">Il n\'y a aucune image stockée dans la base de données ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}

require_once "../view_style/disk_space.view.php";