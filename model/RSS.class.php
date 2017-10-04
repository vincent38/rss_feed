<?php

include_once('Nouvelle.class.php');

class RSS {
    private $titre; // Titre du flux
    private $url;   // Chemin URL pour télécharger un nouvel état du flux
    private $date;  // Date du dernier téléchargement du flux
    private $nouvelles; // Liste des nouvelles du flux dans un tableau d'objets Nouvelle

    // Contructeur
    function __construct($url = null) {
        if ($url !== null) {
            $this->url = $url;
        }
    }

    // Getter générique
    function __get($name) {
        return $this->$name;
    }

    // Setter générique
    function __set($name, $value) {
        $this->$name = $value;
    }

    function titre() {
        return $this->titre;
    }

    function nouvelles() {
        return $this->nouvelles;
    }

    // Récupère un flux à partir de son URL
    function update() {
        //Définition du 1° ID d'image
        $id = 1;

        // Cree un objet pour accueillir le contenu du RSS : un document XML
        $doc = new DOMDocument;

        //Telecharge le fichier XML dans $doc
        $doc->load($this->url);

        // Recupère la liste (DOMNodeList) de tous les elements de l'arbre 'title'
        $nodeList = $doc->getElementsByTagName('title');

        // Met à jour le titre dans l'objet
        $this->titre = $nodeList->item(0)->textContent;
        
        // Récupère tous les items du flux RSS
        foreach ($doc->getElementsByTagName('item') as $node) {
            
            // Création d'un objet Nouvelle à conserver dans la liste $this->nouvelles
            $nouvelle = new Nouvelle();
            
            // Modifie cette nouvelle avec l'information téléchargée
            $nouvelle->update($node, $id);

            //Ajout de la nouvelle
            $this->nouvelles[] = $nouvelle;
            
            //MàJ ID
            $id++;
        }
    }

}