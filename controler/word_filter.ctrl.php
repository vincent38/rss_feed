<?php
/* FILTRE DU CONTENU DES NOUVELLES PAR MOTS-CLES */

// Vérification de l'authentification
require_once('redirect.ctrl.php');

// Includes principaux
require_once('../model/RSS.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/DAO.class.php');

// Création de l'objet DAO
$dao = new DAO();

$userL = $_SESSION['user'] -> getLogin();

if (isset($_POST['filter_chain'])) {
    $filter_chain = $_POST['filter_chain'];

    // On vérifie que la chaîne n'est pas vide
    if (rtrim($filter_chain)) {
        // On supprime tous les espaces de la chaîne
        $filter_chain = preg_replace('/\s+/', '', $filter_chain);        

        // On enregistre la chaîne filtre dans la base de données
        $result = $dao->update_word_filter($userL, $filter_chain);

        // On affiche un message de validation si tout s'est bien passé
        if ($result) {
            $readable_chain = str_replace(",", " - ", $filter_chain);

            $alert['message'] = "Les mots clés suivants sont désormais bloqués :<br><b>".$readable_chain."</b>";
            $alert['type'] = "success";
            $alert['icon'] = "pe-7s-check";
        } else {
            $alert['message'] = "Erreur : impossible de mettre à jour les mots clés";
            $alert['type'] = "danger";
            $alert['icon'] = "pe-7s-attention";
        }
    } else { // Si la chaîne est vide, on supprime la chaîne filtre de l'utilisateur
        $dao->removeFilterChain($userL);

        // On affiche un message de succès
        $alert['message'] = "Suppression des mots-clés filtres réalisée avec succès !";
        $alert['type'] = "success";
        $alert['icon'] = "pe-7s-check";
    }
}

// On récupère la chaîne filtre pour l'utilisateur courant et on l'affiche
$data['chain'] = $dao->getFilterChain($userL);

// On récupère le nombre de nouvelles actuellement filtrées par la chaîne
$data['stats'] = $dao->getFilterStats($userL);

// Vue
require_once "../view_style/word_filter.view.php";