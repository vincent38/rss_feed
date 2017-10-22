<?php
/*
Signin : connexion de l'utilisateur
*/
session_start();
if (isset($_SESSION["user"]) and $_SESSION["user"] != null) {
    // Si l'utilisateur est déjà connecté, il est redirigé vers l'acceuil
    header("Location: afficher_flux.ctrl.php");
}

require_once("../model/UserManager.class.php");
require_once("../model/User.class.php");

$uM = new UserManager;

if (!empty($_POST["username"]) and !empty($_POST["password"])) {
    // Inscription
    $reply = $uM->login($_POST["username"], $_POST["password"]);

    // Si le login a fonctionné on authentifie l'utilisateur
    if ($reply) {
        $_SESSION["user"] = $reply;

        // On redirige l'utilisateur vers la page d'acceuil
        header ("Location: afficher_flux.ctrl.php?logged");

    } else {
        $alert['message'] = "La connexion au compte a échouée. Vérifiez vos identifiants.";
        $alert['type'] = "danger";
        $alert['icon'] = "pe-7s-close-circle";
    }
// Si l'utilisateur a essayé d'accéder à une page sans autorisation, on affiche une notification
} else if (isset ($_GET['forbidden'])) {
    $alert['message'] = "Pour accéder à ces fonctionnalités, veuillez vous identifier.";
    $alert['type'] = "warning";
    $alert['icon'] = "pe-7s-attention";
}

include "../view_style/signin.view.php";