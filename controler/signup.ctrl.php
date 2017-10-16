<?php
/*
Signup : inscription de l'utilisateur
*/
//Are u logged in ?
session_start();
if (isset($_SESSION["user"]) and $_SESSION["user"] != null) {
    //Goodbye
    header("Location: afficher_flux.ctrl.php");
}

require_once("../model/UserManager.class.php");

$uM = new UserManager;

if (isset($_POST["username"]) and isset($_POST["password"])) {
    //Inscription
    $reply = $uM->register($_POST["username"], $_POST["password"]);
    if ($reply) {
        $msg = "Inscription effectuée avec succès ! <br>\n Vous pouvez maintenant vous connecter <a href='signin.ctrl.php'>sur cette page</a>.";
    } else {
        $error = "Une erreur est survenue à l'inscription : un utilisateur porte le même pseudonyme !";
    }
}

include "../view/signup.view.php";