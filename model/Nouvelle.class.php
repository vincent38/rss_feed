<?php

class Nouvelle {
    private $id; // id de la nouvelle
    private $date;    // Date de publication
    private $titre;   // Le titre
    private $description; // Contenu de la nouvelle
    private $url;         // Le lien vers la ressource associée à la nouvelle
    private $urlImage;    // URL vers l'image

    // Fonctions getter
    function titre() {
        return $this->titre;
    }

    function date() {
        return $this->date;
    }

    function description() {
        return $this->description;
    }

    function url() {
        return $this->url;
    }

    function urlImage() {
        return $this->urlImage;
    }

    function id() {
        return $this->id;
    }



    // Extrait la structure DOM du noeud enclosure
    function downloadImage(DOMElement $item, $imageId) {
        $node = $item->getElementsByTagName('enclosure');

        if ($node->length != 0){
           // On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
            // On tente d'accéder à l'attribut 'url'
            $node = $node->item(0)->attributes->getNamedItem('url');

            if ($node != NULL) {
                // L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
                $url = $node->nodeValue;
                // On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
                $this->urlImage = '../data/images/'.$imageId;
                // On télécharge l'image à l'aide de son URL, et on la copie localement.
                file_put_contents($this->urlImage, file_get_contents($url));
            } 
        }
    }

    // Charge les attributs de la nouvelle avec les informations du noeud XML
    function update(DOMElement $item, $id = null) {
        $this->titre = $item->getElementsByTagName('title')->item(0)->textContent;
        $this->date = $item->getElementsByTagName('pubDate')->item(0)->textContent;
        $this->description = $item->getElementsByTagName('description')->item(0)->textContent;
        $this->url = $item->getElementsByTagName('guid')->item(0)->textContent;
        if ($id !== null) {
            $this->updateImage($item, $id);
        }
    }

    // Se charge de mettre à jour l'image
    function updateImage(DOMElement $item, $id) {
        $images = $item->getElementsByTagName('enclosure');
        if ($images->length != 0){
            $this->downloadImage($item, $id);
        }
    }
}