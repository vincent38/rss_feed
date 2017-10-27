<?php
/* AFFICHAGE DE L'ESPACE DISQUE OCCUPE PAR CHAQUE FLUX */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

// Ajout flux
require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

$data = array();

require_once "../view_style/disk_space.view.php";