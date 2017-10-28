<?php
/* AFFICHAGE DE TOUTES LES NOUVELLES D'UN FLUX PAR DATE*/

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

/* Variable globale data contenant les données passées à la vue */
$data = array();

if (isset($_POST['time'])) {
    $opt_time = array ("ajd", "week", "all");

    // Si le paramètre passé en POST est valide
    if (in_array($_POST['time'], $opt_time)) {
        $opt_time = $_POST['time'];
    } else {
        $opt_time = "ajd"; // par défaut
    }
} else {
    $opt_time = "ajd"; // par défaut
}

// On stocke l'information sur le paramètre date sélectionné dans l'array $data
$data['selectedDate'] = $opt_time;

$allNews = $dao->getAllMixedNews($opt_time);

if ($allNews) {
    foreach ($allNews as $new) {
        /* On ajoute le titre du flux contenant dans l'objet new */
        $new->titreFlux = $dao->readRSSfromID($new->RSS_id())->titre();

        /* On ajoute l'objet NEW dans l'array data */
        $data['news'][] = $new;
    }
} else { // Aucune nouvelle dans la base de données

    $noResult['type'] = "Aucune nouvelle";
    $noResult['message'] = '<p class="special-subtext">Rien de neuf ici... <a href="force_update.ctrl.php">Mettre à jour les flux</a></p>';    

}

require_once "../view_style/afficher_date.view.php";