<?php

// Vérification de l'authentification
require_once('redirect.ctrl.php');

// Includes principaux
require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

// Création de l'objet DAO
$dao = new DAO();

$userL = $_SESSION['user'] -> getLogin();

if (isset($_POST['toBlock'])) {
    // On vérifie que les paramètres envoyés sont valides
    $params = array("typo", "img", "iframe", "a", "script", "noBlock");
    $valide = true;

    foreach ($_POST['toBlock'] as $arg) {
        if (!in_array($arg, $params)) {
            $valide = false;
            break;
        }
    }

    if ($valide) {
        // On vérifie si l'utilisateur veut désactiver la fonctionnalité
        if ($_POST['toBlock']=='noBlock') {
            // On supprime l'entrée dans la base de données, si elle existe
            $dao->removeHTMLFilter($userL);
        } else {
            $params = "";

            // On formate la chaîne de paramètres à passer
            foreach ($_POST['toBlock'] as $toBlock) {
                $params .= "<".$toBlock.">";
            }

            // On met à jour les paramètres utilisateur
            $dao->update_HTML_filter($userL, $params);
        }

        $alert['message'] = "Paramètres mis à jour avec succès !";
        $alert['type'] = "success";
        $alert['icon'] = "pe-7s-check";
    } else { // On affiche un message d'erreur
        $alert['message'] = "Erreur : paramètres d'entrée invalides ! Contenu HTML corrompu";
        $alert['type'] = "danger";
        $alert['icon'] = "pe-7s-attention";
    }
}

// On récupère les paramètres utilisateur
$filter_chain = $dao->getHTMLFilter($userL);

// var_dump de ce qu'on trouve
var_dump($filter_chain);

// Vue
require_once "../view_style/html_filter.view.php";