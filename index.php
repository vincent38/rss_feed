<?php
// Are u logged in ?
session_start();
//Redirection vers startup appli
header("Location: controler/afficher_flux.ctrl.php");
?>