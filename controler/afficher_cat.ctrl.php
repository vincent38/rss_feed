<?php
/* AFFICHAGE DES NOUVELLES PAR CATEGORIES */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

// Ajout flux
require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

$data = array();

// Déclaration de la variable contenant les messages utilisateur
$alert = array();

/* Tableau contenant tous les codes couleur bootstrap */
$allCodes = array ("btn-success", "btn-info", "btn-warning", "btn-danger", "btn-default");

/* Récupération de l'objet utilisateur à partir de la variable de session */
$current_user = $_SESSION["user"];

/* On récupère toutes les catégories de l'utilisateur */
$allCat = $dao->getAllCat($current_user->getLogin());

/* Si le tableau n'est pas vide, alors : */
if ($allCat) {
    // On formate l'objet allCat et on le stocke dans $data
    $i = 0; $clearCat = array();

    foreach ($allCat as $ind => $cat) {
        $clearCat[$ind] = array("nom" => $cat, "icon" => $allCodes[$i % 5]);
        $i++;
    }

    $data['cat'] = $clearCat;

    /* Si l'utilisateur a déjà sélectionné une catégorie */
    if (!empty($_POST['categorie'])) {
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

    // Par défaut : on récupère des news du dernier jour
    $news = $dao->getNewsFromCat($current_user->getLogin(), $selectedCat, 1);

    // S'il y a des résultats dans cette catégorie
    if ($news) {
        // On ajoute le nom du flux père à chaque objet nouvelle
        foreach ($news as $new) {
            $new->titreFlux = ($dao->readRSSfromID($new->RSS_id()))->titre();
        }

        // On stocke toutes les informations dans l'objet data
        $data['news'] = $news;

    } else { // Sinon on affiche un message d'erreur
        $noResult = array(); $noResult['type'] = "Catégorie vide";
        $noResult['message'] = '<p class="special-subtext">Rien de neuf ici pour les dernières 24 heures... <a href="force_update.ctrl.php">Mettre à jour les flux</a></p>';      
    }

    $data['selectedCat'] = $selectedCat;

} else {
    $noResult = array(); $noResult['type'] = 'Aucun abonnement';
    $noResult['message'] = '<p class="special-subtext">Vous n\'êtes abonné à aucun flux ! <a href="manage_subs.ctrl.php">Créer un abonnement</a></p>';   
}


require_once "../view_style/afficher_cat.view.php";