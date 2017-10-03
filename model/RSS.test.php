<?php
// Test de la classe RSS
require_once('RSS.class.php');
require_once('Nouvelle.class.php');

// Une instance de RSS
$rss = new RSS('http://www.lemonde.fr/m-actu/rss_full.xml');

// Charge le flux depuis le réseau
$rss->update();

// Affiche le titre
echo $rss->titre()."<br><br>\n";

foreach($rss->nouvelles() as $nouvelle) {
    echo ' <a href="'.$nouvelle->url().'">'.$nouvelle->titre().'</a> '.$nouvelle->date()."<br>\n";
    echo '<img src="'.$nouvelle->urlimage().'" alt="image"><br><br>'."\n";
    echo '  '.$nouvelle->description()."<br><br>\n";
}