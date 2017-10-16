<?php
// Are u logged in ?
session_start();

if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
    // Goodbye
    header("Location: afficher_flux.ctrl.php");
}

//Vue
header("Location: controler/afficher_flux.ctrl.php");
?>