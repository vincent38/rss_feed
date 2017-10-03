<?php
class RSS {
    private $titre; // Titre du flux
    private $url;   // Chemin URL pour télécharger un nouvel état du flux
    private $date;  // Date du dernier téléchargement du flux
    private $nouvelles; // Liste des nouvelles du flux dans un tableau d'objets Nouvelle

    // Contructeur
    function __construct($url) {
        $this->url = $url;
    }

    // Fonctions getter

    function titre() {
        return $this->titre;
    }

}