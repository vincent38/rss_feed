<?php
/* Affichage de la liste des abonnements d'un utilisateur, trié par catégorie */

require_once("../model/User.class.php");
// Vérification de l'authentification
require_once('redirect.ctrl.php');
require_once("../model/RSS.class.php");
require_once("../model/DAO.class.php");

$dao = new DAO();

$data = array();

/* Récupération de l'objet utilisateur à partir de la variable de session */
$current_user = $_SESSION["user"];

/* On recherche tous les abonnements de l'utilisateur et on les stocke dans la variable $data */
$data = $dao->getAbo($current_user->getLogin());


include "../view_style/afficher_subs.view.php";