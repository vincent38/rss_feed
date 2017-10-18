<?php
/* Gestion des abonnements d'un utilisateur */

require_once("../model/User.class.php");

// Vérification de l'authentification
require_once('redirect.ctrl.php');

require_once("../model/RSS.class.php");
require_once("../model/DAO.class.php");

$dao = new DAO();

// Si les paramètres en POST sont définis, alors on ajoute l'abonnement voulu par l'utilisateur
if (isset($_POST["flux"]) and isset($_POST["titre"]) and isset($_POST["cat"])) {
    // Si tous les champs donnés sont non vides
    if (rtrim($_POST["flux"]) && rtrim($_POST["titre"]) && rtrim($_POST["cat"])) {
        $status = $_SESSION["user"]->ajoutAbonnement($_POST["flux"], $_POST["titre"], $_POST["cat"]);

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

/* On stocke tous les flux enregistrés dans la BDD et on les affiche */
foreach ($dao->getRSSFlux() as $f) {
    $data[] = $f;
}


include "../view_style/manage_subs.view.php";