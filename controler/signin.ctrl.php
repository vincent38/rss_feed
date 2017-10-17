<?php
/*
Signin : connexion de l'utilisateur
*/
//Are u logged in ?
session_start();
if (isset($_SESSION["user"]) and $_SESSION["user"] != null) {
    //Goodbye
    header("Location: afficher_flux.ctrl.php");
}
require_once("../model/UserManager.class.php");
require_once("../model/User.class.php");

$uM = new UserManager;

if (isset($_POST["username"]) and isset($_POST["password"])) {
    // Inscription
    $reply = $uM->login($_POST["username"], $_POST["password"]);

    // Si le login a fonctionné on authentifie l'utilisateur
    if ($reply) {
        $_SESSION["user"] = $reply;
        header("Location: afficher_flux.ctrl.php");
    } else {
        $error = "La connexion au compte a échouée! Vérifiez vos identifiants.";
    }
}

include "../view/signin.view.php";