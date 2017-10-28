<?php
/* SUPPRESSION DU CONTENU DES FLUX (IMAGES, NOUVELLES) */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

// Déclaration de la variable contenant les messages d'erreur
$alert = array();

if (!empty($_POST['toClean'])) {
    $opt_time = array("up1" => 1, "up2" => 2, "up14" => 14, "upAll" => -1);

    // On vérifie que le paramètre passé en POST est valide
    if (isset ($_POST['time']) && array_key_exists($_POST['time'], $opt_time)) {
        $upT = $opt_time[$_POST['time']];

        $alert['message'] = "Les flux suivants ont été purgés : <br>";
        foreach ($_POST['toClean'] as $rssData) {
            // On traite la chaîne passée en POST
            $rssID = explode("|", $rssData);

            // On récupère l'objet RSS et on supprime les images qui lui sont associées, dans le laps de temps $upT
            $rssObj = $dao->readRSSfromID($rssID[0]);
            $rssObj->deleteImg($upT);

            // On supprime toutes les nouvelles associées au flux RSS, dans le laps de temps $upT
            $dao->purgeRSSFlux($rssID[0], $upT);
    
            $alert['message'] .= "<b>".$rssID[1]."</b><br>";
        }
    
        $alert['type'] = "success";
        $alert['icon'] = "pe-7s-check";

    } else {        
        $alert['message'] = "Paramètres invalides !";
        $alert['type'] = "danger";
        $alert['icon'] = "pe-7s-attention";
    }

} else if (isset($_POST['time'])) {

    $alert['message'] = "Veuillez choisir des flux à purger";
    $alert['type'] = "warning";
    $alert['icon'] = "pe-7s-close-circle";

}

/* Variable globale data contenant les données passées à la vue */
$data = array();
$allFlux = $dao->getRSSFlux();

if ($allFlux) {
    $data = $allFlux;
} else {
    $noResult = array(); $noResult['type'] = 'Aucun flux';
    $noResult['message'] = '<p class="special-subtext">Vous n\'avez enregistré aucun flux ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}

// Vue
require_once "../view_style/clean_flux.view.php";
