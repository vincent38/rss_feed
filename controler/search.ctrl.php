<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

/* Variable globale data contenant les données passées à la vue */
$data = array();
$results = false;

/* Si les mots clés de recherche sont définis et qu'ils ne sont pas vides */
if (isset($_POST['searchstr']) && rtrim($_POST['searchstr'])) {
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
            $new->urlParsed = "afficher_nouvelle.ctrl.php?newID=".$new->id()."&rssID=".$rssID;
            $data[] = $new;            
        }
    } else { // On affiche un message d'erreur
        $alert['message'] .= "Aucun résultat trouvé pour la requête : <br><b>".$_POST['searchstr']."</b>";
        $alert['type'] = "warning";
        $alert['icon'] = "pe-7s-check";
    }
}

// Vue
include "../view_style/search.view.php";
