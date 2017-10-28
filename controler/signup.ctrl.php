<?php
/* INSCRIPTION DE L'UTILISATEUR */

require_once("../model/User.class.php");
require_once("../model/UserManager.class.php");

// Déclaration de la variable contenant les messages d'erreur
$alert = array();

session_start();
if (isset($_SESSION["user"]) and $_SESSION["user"] != null) {
    // Si l'utilisateur est déjà connecté, il est redirigé vers l'acceuil
    header("Location: afficher_flux.ctrl.php");

    // On arrête le script PHP
    exit();
}

$uM = new UserManager;

if (!empty($_POST["username"]) and !empty($_POST["password"])) {
    //Inscription
    $reply = $uM->register($_POST["username"], $_POST["password"]);

    if ($reply) {
        $alert['message'] = "Inscription effectuée avec succès ! <br> Vous pouvez maintenant vous connecter <b><a href=\'signin.ctrl.php\'>sur cette page</a>.</b>";
        $alert['type'] = "success";
        $alert['icon'] = "pe-7s-check";
        $alert['time'] = 30000;
    } else {
        $alert['message'] = "Une erreur est survenue à l\'inscription : un utilisateur porte le même pseudonyme !";
        $alert['type'] = "warning";
        $alert['icon'] = "pe-7s-close-circle";
    }
}

require_once "../view_style/signup.view.php";