<?php
/*
Goodbye
*/
session_start();
if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
    //Already out
    header("Location: afficher_flux.ctrl.php");

    // On arrête le script PHP
    exit();
}

/* On supprime la session utilisateur et on le redirige vers l'accueil */
session_unset();
session_destroy();

header("Location: afficher_flux.ctrl.php?delogged=true");

// On arrête le script PHP
exit();