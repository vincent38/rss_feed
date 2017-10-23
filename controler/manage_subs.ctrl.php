<?php
/* Gestion des abonnements d'un utilisateur */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once("../model/RSS.class.php");
require_once("../model/DAO.class.php");

$dao = new DAO();

// Si les paramètres en POST sont définis, alors on ajoute l'abonnement voulu par l'utilisateur
if (isset($_POST["flux"]) and isset($_POST["titre"]) and isset($_POST["cat"])) {
    // On traite les valeurs reçues
    $pFlux = rtrim($_POST["flux"]);
    $pTitre = rtrim($_POST["titre"]);
    $pCat = rtrim($_POST["cat"]);

    // Si tous les champs donnés sont non vides
    if ($pFlux && $pTitre && $pCat) {        
        $status = $_SESSION["user"]->ajoutAbonnement($pFlux, $pTitre, $pCat);

        // Si la requête a fonctionné, alors on envoie un message succès
        if ($status) {
            $alert['message'] = "Vous êtes désormais abonné au flux : <br><b>".$_POST["titre"]."</b> dans la catégorie <b>".$_POST["cat"]."</b>";
            $alert['type'] = "success";
            $alert['icon'] = "pe-7s-check";
        } else {
            $alert['message'] = "Vous êtes déjà abonné à ce flux dans cette catégorie !";
            $alert['type'] = "danger";
            $alert['icon'] = "pe-7s-attention";
        }
    } else {
        $alert['message'] = "Veuillez remplir tous les champs";
        $alert['type'] = "warning";
        $alert['icon'] = "pe-7s-close-circle";
    }
}

$data = array();

/* On récupère les flux enregistrés */
$data = $dao->getRSSFlux();

/* Si la liste est vide, on affiche un message d'erreur */
if (!$data) {    
    $noResult['type'] = 'Aucun flux';
    $noResult['message'] = '<p class="special-subtext">Vous n\'avez enregistré aucun flux ! <a href="add_flux.ctrl.php">Ajouter un flux</a></p>';   
}


include "../view_style/manage_subs.view.php";