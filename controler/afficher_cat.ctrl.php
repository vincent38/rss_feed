<?php
/* Affichage des nouvelles par catégorie */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

// Ajout flux
require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

$dao = new DAO();

$data = array();

/* Tableau contenant tous les codes couleur bootstrap */
$allCodes = array ("btn-success", "btn-info", "btn-warning", "btn-danger", "btn-default");

/* Récupération de l'objet utilisateur à partir de la variable de session */
$current_user = $_SESSION["user"];

/* On récupère toutes les catégories de l'utilisateur */
$allCat = $dao->getAllCat($current_user->getLogin());

/* Si le tableau n'est pas vide, alors : */
if ($allCat) {
    /* Si l'utilisateur a déjà sélectionné une catégorie */
    if (isset($_POST['categorie'])) {
        /* On vérifie que l'utilisateur est abonné à cette catégorie au moment de la requête */
        if (in_array($_POST['categorie'], $allCat)) {
            $selectedCat = $_POST['categorie'];
        } else {
            $alert['message'] = "Vous n'êtes pas abonné à cette catégorie !";
            $alert['type'] = "warning";
            $alert['icon'] = "pe-7s-close-circle";
        }
    } else { // Sinon on prend la première catégorie qui apparaît dans la liste
        $selectedCat = $allCat[0];
    }

    // On récupère les nouvelles récentes des flux de cette catégorie et on les ajoute à data <dernier jour pour l'instant>
    if ($selectedCat) {
        $news = $dao->getNewsFromCat($current_user->getLogin(), $selectedCat, 1);

        // On ajoute le nom du flux père à chaque objet nouvelle
        foreach ($news as $new) {
            $new->titreFlux = ($dao->readRSSfromID($new->RSS_id()))->titre();
        }

        // On formate l'objet allCat
        $i = 0;

        foreach ($allCat as $ind => $cat) {
            $allCat[$ind] = array("nom" => $cat, "icon" => $allCodes[$i % 5]);
            $i++;
        }

        // On stocke toutes les informations dans l'objet data
        $data['news'] = $news;
        $data['cat'] = $allCat;
        $data['selectedCat'] = $selectedCat;
    }

} else {
    // Plus tard : message à afficher dans la page pour signaler qu'il n'y a aucun abonnement
}


require_once "../view_style/afficher_cat.view.php";