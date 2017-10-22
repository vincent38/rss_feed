<?php
require_once("../model/User.class.php");

// Are you logged in ?
session_start();
if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
    // Goodbye
    header("Location: signin.ctrl.php?forbidden");

    // On arrête le script PHP
    exit();
}