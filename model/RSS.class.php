<?php

include_once('Nouvelle.class.php');
require_once('DAO.class.php');

class RSS {
    private $id;    // ID du flux en BDD
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

    // Un lien pour la consultation des nouvelles du flux
    function urlParsed() {
        return "afficher_nouvelles.ctrl.php?rssID=".$this->id;
    }

    function titre() {
        return $this->titre;
    }

    function date() {
        return $this->date;
    }

    function url() {
        return $this->url;
    }

    function nouvelles() {
        return $this->nouvelles;
    }

    // Supprime les images associées au flux RSS, et les entrées des tables Nouvelle, RSS et Abonnement
    function delete() {
        // Objet DAO
        global $dao;

        // On récupère toutes les nouvelles associées à ce flux
        $this->deleteImg();

        // On supprime toutes les nouvelle associées au flux RSS
        $dao->purgeRSSFlux($this->id);

        // On supprimer l'entrée dans la table RSS
        $dao->deleteRSSFlux($this->id);
    }

    // Supprime les images associées au flux RSS
    function deleteImg($upT = -1) {
        // Objet DAO
        global $dao;

        // On récupère toutes les nouvelles associées à ce flux, dans le laps de temps $upT
        $allNews = $dao->getAllNews($this->id, $upT);

        // Pour chaque nouvelle : on supprime l'image associée
        foreach ($allNews as $new) {
            // Suppression de l'image associée à la nouvelle
            if (file_exists($new->urlImage()))
                unlink($new->urlImage());
        }
    }

    // Récupère un flux à partir de son URL
    function update() {
        // Objet DAO
        global $dao;

        //Mise à jour date
        $dao->updateRSS($this);

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
            $nouvelle->update($node);

            // On n'a pas la nouvelle dans la table, on l'ajoute
            if ($dao->readNouvellefromTitre($nouvelle->titre(),$this->id) === null) {
                //Ajout nouvelle dans la BDD
                $idN = $dao->createNouvelle($nouvelle, $this->id);

                // Ajout image et lien avec la nouvelle
                $nouvelle->downloadImage($node, $idN);
                $dao->addImageToNouvelle($nouvelle->urlImage(), $idN);
            } else {
                $nouvelle = $dao->readNouvellefromTitre($nouvelle->titre(),$this->id);
            }

            //Ajout de la nouvelle
            $this->nouvelles[] = $nouvelle;
        }
    }

}
