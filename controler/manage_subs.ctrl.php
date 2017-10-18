<?php
/*
Outil de gestion des abonnements d'un utilisateur
*/
//Are u logged in ?
session_start();
if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
    //Goodbye
    header("Location: signin.ctrl.php");
}

function __autoload($classname) {
    $filename = "../model/". $classname .".class.php";
    include_once($filename);
}

require_once("../model/RSS.class.php");
require_once("../model/DAO.class.php");
$dao = new DAO;

if (isset($_POST["flux"]) and isset($_POST["titre"]) and isset($_POST["cat"])) {
    $_SESSION["user"]->ajoutAbonnement($_POST["flux"], $_POST["titre"], $_POST["cat"]);
}

$data = array();

foreach ($dao->getRSSFlux() as $f) {
    $data[] = $f;
}

include "../view/manage_subs.view.php";