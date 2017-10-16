<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

$dao = new DAO();

/* Variable globale data contenant les données passées à la vue */
$data = array();
$results = false;

var_dump($_POST);

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
        /* On formate les résultats trouvés */
        foreach ($foundNews as $new) {
            /* On ajoute l'objet NEW dans l'array data */
            $new->urlParsed = "afficher_nouvelle.ctrl.php?newID=".$new->id()."&rssID=".$rssID;
            $data[] = $new;
        }

        $results = true;
    }
}

// Vue
include "../view/search.view.php";
