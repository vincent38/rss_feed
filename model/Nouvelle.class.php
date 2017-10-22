<?php

class Nouvelle {
    private $id; // id de la nouvelle
    private $date;   // Timestamp UNIX de la date de la nouvelle
    private $titre;   // Le titre
    private $description; // Contenu de la nouvelle
    private $url;         // Le lien vers la ressource associée à la nouvelle
    private $urlImage;    // URL vers l'image (référence locale)

    private $RSS_id; // RSS_id du flux contenant la nouvelle

    // Fonctions getter
    function titre() {
        return $this->titre;
    }

    function RSS_id() {
        return $this->RSS_id;
    }

    // Renvoie la date formatée "en français" à partir du timestamp
    function date() {
        return date("d/m/Y H:i:s", $this->date);
    }

    // Renvoie l'URL d'accès à la nouvelle
    function urlParsed() {
        return "afficher_nouvelle.ctrl.php?newID=".$this->id()."&rssID=".$this->RSS_id();
    }

    // Renvoie le timestamp UNIX de la date
    function real_date() {
        return $this->date;
    }

    function description() {
        // Si un utilisateur est connecté et possède des filtres HTML, on les applique à la nouvelle
        // sinon on renvoie le corps de la nouvelle inchangé
        $filtered = $this->filterHTML($this->description);

        if ($filtered) {
            return $filtered;
        } else {
            return $this->description;
        }
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

        // On convertit la date RSS (qui suit le standard RFC 2822) en timestamp
        $this->date = strtotime($this->date);
    }

    // Se charge de mettre à jour l'image
    function updateImage(DOMElement $item, $id) {
        $images = $item->getElementsByTagName('enclosure');
        if ($images->length != 0){
            $this->downloadImage($item, $id);
        }
    }

    // Surligne les occurences du tableau $s_str dans le titre et le corps de la nouvelle
    public function highlight(array $s_str) {
        foreach ($s_str as $keyword) {
            // On utilise preg_quote pour éviter des "interférences" entre la syntaxe régulière et les arguments de recherche
            $this->description = preg_replace("/".preg_quote($keyword, "/")."/i", '<span class="special-highlight">$0</span>', $this->description);    
            $this->titre = preg_replace("/".preg_quote($keyword, "/")."/i", '<span class="special-highlight">$0</span>', $this->titre);           
        }

        // Ancienne solution fonctionnelle mais qui faisait perdre l'information de la casse : expression régulière plus haut adaptée de stackoverflow */
        /*
            $this->description = str_ireplace($keyword, '<span class="special-highlight">'.$keyword.'</span>', $this->description);
            $this->titre = str_ireplace($keyword, '<span class="special-highlight">'.$keyword.'</span>', $this->titre);
        */
    }

    // Applique les filtres HTML éventuels sur le corps de la nouvelle
    private function filterHTML($description) : string {
        $filtered = "";

        require_once("../model/User.class.php");
        require_once("../model/DAO.class.php");

        // Instanciation de l'objet DAO
        $dao = new DAO();

        // On démarre la session si elle n'est pas déjà lancée
        if (session_status() == PHP_SESSION_NONE) session_start();

        // Si un utilisateur est connecté
        if (isset($_SESSION["user"]) && $_SESSION["user"] !== null) {
            $userL = $_SESSION['user']->getLogin();
            $filter = $dao->getHTMLFilter($userL);

            // Si l'utilisateur utilise des filtres, ils sont appliqués
            if ($filter) {
                $filtered = strip_tags($description, $filter);
            }
        }
        // sinon aucun filtre n'est appliqué

        return $filtered;
    }
}
