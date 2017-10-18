<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

/* Variable globale data contenant les données passées à la vue */
$data = array();
$results = false;

/* Si une recherche a été lancée */
if (isset($_POST['searchstr'])) {

    /* Si les mots clés de recherche ne sont pas vides */
    if (rtrim($_POST['searchstr'])) {
        /* Définition des paramètres de recherche */
        $s_str = $_POST['searchstr'];
        $strict = ($_POST['typeS'] == "allT");
        $onlyT = ($_POST['modeS'] == "t_only");
        $time = $_POST['time'];

        /* Variable globale data contenant les données passées à la vue */
        $data = array();

        $foundNews = $dao->searchNews ($s_str, $strict, $onlyT, $time);

        if ($foundNews) { // Si on a trouvé des résultats
            $results = true;

            /* On formate les résultats trouvés */
            foreach ($foundNews as $new) {
                /* On ajoute l'objet NEW dans l'array data */
                // On crée un lien pour lire la nouvelle
                $new->urlParsed = "afficher_nouvelle.ctrl.php?newID=".$new->id()."&rssID=".$new->RSS_id();

                // On ajoute le titre du flux aux infos envoyées
                $new->titreFlux = ($dao->readRSSfromID($new->RSS_id()))->titre();

                $data[] = $new;
            }
        } else { // On signale à l'utilisateur qu'aucun résultat n'a été trouvé
            $alert['message'] .= "Aucun résultat trouvé pour la requête : <br><b>".$_POST['searchstr']."</b>";
            $alert['type'] = "warning";
            $alert['icon'] = "pe-7s-check";
        }
    } else { // On demande à l'utilisateur de taper des mots clés valides
        $alert['message'] .= "Veuillez taper des mots clés de recherche valides";
        $alert['type'] = "danger";
        $alert['icon'] = "pe-7s-attention";
    }
}

// Vue
include "../view_style/search.view.php";
