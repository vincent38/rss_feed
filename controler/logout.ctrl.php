<?php
/*
Goodbye
*/
session_start();
if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
    //Already out
    header("Location: afficher_flux.ctrl.php");
}

session_unset();
session_destroy();
header("Location: afficher_flux.ctrl.php");