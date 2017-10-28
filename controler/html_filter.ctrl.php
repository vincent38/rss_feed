<?php
/* CHOIX DE BALISES HTML A BLOQUER\AUTORISER DANS LE CONTENU DES NOUVELLES */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

// Includes principaux
require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

// Déclaration de la variable contenant les messages utilisateur
$alert = array();

$userL = $_SESSION['user'] -> getLogin();

if (isset($_POST['toBlock'])) { // => note : erreur dans le nommage du paramètre, il s'agit bien des balises à AUTORISER
    // On vérifie que les paramètres envoyés sont valides
    $params = array("typo", "img", "iframe", "a", "script", "noBlock");
    $valide = true;

    if (is_array($_POST['toBlock'])) {
        foreach ($_POST['toBlock'] as $arg) {
            if (!in_array($arg, $params)) {
                $valide = false;
                break;
            }
        }
    } else {
        if (!in_array($_POST['toBlock'], $params)) {
            $valide = false;
        }
    }

    if ($valide) {
        // On vérifie si l'utilisateur veut désactiver la fonctionnalité
        if ($_POST['toBlock']=='noBlock') {
            // On supprime l'entrée dans la base de données, si elle existe
            $dao->removeHTMLFilter($userL);
        } else {
            // Par défaut, la balise span est toujours autorisée
            $params = "<span>";

            // On formate la chaîne de paramètres à passer
            foreach ($_POST['toBlock'] as $toAuth) {
                if ($toAuth == 'typo')
                    // On ajoute toutes les balises généralement utilisées pour du simple formatage
                    $params .= "<b><p><strong><i><u><s><br><h1><h2><h3><h4><h5><h6><ul><li>";
                else
                    $params .= "<".$toAuth.">";
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
$params = explode("><", $dao->getHTMLFilter($userL));

foreach ($params as $key => $arg) {
    $params[$key] = str_replace("<", "", $arg);
    $params[$key] = str_replace(">", "", $params[$key]);
}

$params[0] = str_replace("<", "", $params[0]);

$data = $params;

// Vue
require_once "../view_style/html_filter.view.php";