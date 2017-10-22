<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

/* Variables globales contenant les données passées à la vue */
$data = array();
$data_opt = array();

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
        $highlight = !($_POST['highlight'] == "");

        // On stocke les paramètres de recherche dans l'objet $data_opt
        $data_opt['str'] = $s_str;
        $data_opt['strict'] = $strict;
        $data_opt['onlyT'] = $onlyT;
        $data_opt['time'] = $time;
        $data_opt['highlight'] = $highlight;

        /* Variable globale data contenant les données passées à la vue */
        $data = array();
        $s_str = preg_split('/\s+/', $s_str); // On coupe la chaîne par des espaces
    
        /* On appelle la méthode de recherche de DAO */
        $foundNews = $dao->searchNews ($s_str, $strict, $onlyT, $time);

        if ($foundNews) { // Si on a trouvé des résultats
            $results = true;

            /* On formate les résultats trouvés */
            foreach ($foundNews as $new) {
                if ($highlight) {
                    // On surligne toutes les occurences de la search string dans la description et le titre de la nouvelle
                    $new->highlight($s_str);
                }

                // On ajoute le titre du flux aux infos envoyées
                $new->titreFlux = ($dao->readRSSfromID($new->RSS_id()))->titre();

                // On ajoute l'objet NEW dans l'array data
                $data[] = $new;
            }
        } else { // On signale à l'utilisateur qu'aucun résultat n'a été trouvé
            $alert['message'] .= "Aucun résultat trouvé pour la requête : <br><b>".$_POST['searchstr']."</b>";
            $alert['type'] = "warning";
            $alert['icon'] = "pe-7s-info";
        }
    } else { // On demande à l'utilisateur de taper des mots clés valides
        $alert['message'] .= "Veuillez taper des mots clés de recherche valides";
        $alert['type'] = "danger";
        $alert['icon'] = "pe-7s-attention";
    }
}

// Vue
include "../view_style/search.view.php";
