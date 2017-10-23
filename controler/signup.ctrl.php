<?php
/* INSCRIPTION DE L'UTILISATEUR */

require_once("../model/UserManager.class.php");

$uM = new UserManager;

if (!empty($_POST["username"]) and !empty($_POST["password"])) {
    //Inscription
    $reply = $uM->register($_POST["username"], $_POST["password"]);
    if ($reply) {
        $msg = "Inscription effectuée avec succès ! <br>\n Vous pouvez maintenant vous connecter <a href='signin.ctrl.php'>sur cette page</a>.";
    } else {
        $error = "Une erreur est survenue à l'inscription : un utilisateur porte le même pseudonyme !";
    }
}

include "../view_style/signup.view.php";