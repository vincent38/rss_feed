<?php
// Test de la classe RSS
require_once('RSS.class.php');
require_once('Nouvelle.class.php');
require_once('DAO.class.php');

//$url = "http://www.lemonde.fr/m-actu/rss_full.xml";
$url = "http://www.01net.com/rss/info/flux-rss/flux-toutes-les-actualites/";
//$url = "http://www.lefigaro.fr/rss/figaro_flash-actu.xml";
$title = "Le Figaro";

$dao = new DAO();

$rss = $dao->readRSSfromURL($url);
if ($rss == NULL) {
  echo $url." n'est pas connu\n";
  echo "On l'ajoute ... \n";
  $rss = $dao->createRSS($url, $title);
}

// Charge le flux depuis le réseau
$rss->update();

// Affiche le titre
echo $rss->titre."<br><br>\n";

foreach($rss->nouvelles() as $nouvelle) {
    echo ' <a href="'.$nouvelle->url().'">'.$nouvelle->titre().'</a> '.$nouvelle->date()."<br>\n";
    echo '<img src="'.$nouvelle->urlimage().'" alt="image"><br><br>'."\n";
    echo '  '.$nouvelle->description()."<br><br>\n";
}


