<?php
class DAO {
    private $db; // L'objet de la base de donnée

    // Ouverture de la base de donnée
    function __construct() {
        $dsn = 'sqlite:../data/rss.db'; // Data source name
        try {
            $this->db = new PDO($dsn);
        } catch (PDOException $e) {
            exit("Erreur ouverture BD : ".$e->getMessage());
        }
    }

    //////////////////////////////////////////////////////////
    // Methodes CRUD sur RSS
    //////////////////////////////////////////////////////////

    // Récupération de la liste des nouvelles d'un flux RSS (id)
    function getAllNews($rssID) {
        try {
            $q = 'SELECT id, date, titre, description, url, urlImage FROM nouvelle WHERE RSS_id = :rssID';
            $r = $this->db->prepare($q);
            $r->execute(array($rssID));
            $response = $r->fetchAll(PDO::FETCH_CLASS, "Nouvelle");
            if (sizeof($response) > 0){
                return $response;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    // Récupère la liste des flux RSS suivis
    function getRSSFlux() {
        try {
            $q = "SELECT * FROM RSS";
            $r = $this->db->prepare($q);
            $r->execute();
            $response = $r->fetchAll(PDO::FETCH_CLASS, "RSS");
            if (sizeof($response) > 0){
                return $response;
            }           
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    // Crée un nouveau flux à partir d'une URL
    // Si le flux existe déjà on ne le crée pas
    function createRSS($url, $title) {
        $rss = $this->readRSSfromURL($url);
        if ($rss == NULL) {
            try {
                $q = 'INSERT INTO RSS (titre,url,date) VALUES (:title,:url,:date)';
                $r = $this->db->prepare($q);
                $r->bindParam(":title", $title);
                $r->bindParam(":url", $url);
                $t = time();
                $r->bindParam(":date", $t);
                $r->execute();
                if ($r == NULL) {
                    die("createRSS error: no rss inserted\n");
                }
                return $this->readRSSfromURL($url);
            } catch (PDOException $e) {
                die("PDO Error :".$e->getMessage());
            }
        } else {
            // Retourne l'objet existant
            return $rss;
        }
    }

    // Acces à un objet RSS à partir de son URL
    function readRSSfromURL($url) {
        try {
            $q = "SELECT * FROM RSS WHERE url = :url";
            $r = $this->db->prepare($q);
            $r->execute(array($url));
            $response = $r->fetchAll(PDO::FETCH_CLASS, "RSS");
            if (sizeof($response) > 0){
                return $response[0];
            }           
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    // Met à jour un flux
    function updateRSS(RSS $rss) {
        // Met à jour uniquement le titre et la date
        $titre = $this->db->quote($rss->titre());
        $q = "UPDATE RSS SET titre=:titre, date=:d WHERE url=:url";
        try {
            $r = $this->db->prepare($q);
            $titre = $rss->titre;
            $url = $rss->url;
            $date = time();
            $r->bindParam(":titre", $titre);
            $r->bindParam(":d", $date);
            $r->bindParam(":url", $url);
            $r->execute();
        } catch (PDOException $e) {
            die("PDO Error :".$e->getMessage());
        }
    }

    //////////////////////////////////////////////////////////
    // Methodes CRUD sur Nouvelle
    //////////////////////////////////////////////////////////

    // Acces à une nouvelle à partir de son ID et l'ID du flux
    function readNouvellefromID($newID,$RSS_id) {
        try {
            $q = "SELECT * FROM nouvelle WHERE id = :id AND RSS_id = :RSS_id";
            $r = $this->db->prepare($q);
            $r->execute(array($newID, $RSS_id));
            $response = $r->fetchAll(PDO::FETCH_CLASS, "Nouvelle");
            if (sizeof($response) > 0){
                return $response[0];
            }           
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    // Acces à une nouvelle à partir de son titre et l'ID du flux
    function readNouvellefromTitre($titre,$RSS_id) {
        try {
            $q = "SELECT * FROM nouvelle WHERE titre = :titre AND RSS_id = :RSS_id";
            $r = $this->db->prepare($q);
            $r->execute(array($titre, $RSS_id));
            $response = $r->fetchAll(PDO::FETCH_CLASS, "Nouvelle");
            if (sizeof($response) > 0){
                return $response[0];
            }           
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    // Crée une nouvelle dans la base à partir d'un objet nouvelle
    // et de l'id du flux auquelle elle appartient
    function createNouvelle(Nouvelle $n, $RSS_id) {
        $q = "INSERT INTO nouvelle(date, titre, description, url, RSS_id) VALUES (:d, :t, :des, :url, :rss)";
        try {
            $r = $this->db->prepare($q);
            $date = $n->date();
            $titre = $n->titre();
            $description = $n->description();
            $url = $n->url();
            $r->bindParam(":d", $date);
            $r->bindParam(":t", $titre);
            $r->bindParam(":des", $description);
            $r->bindParam(":url", $url);
            $r->bindParam(":rss", $RSS_id);
            $r->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            die("PDOException : ".$e->getMessage());
        }
    }

    // Ajoute une image à une nouvelle
    function addImageToNouvelle($url, $id) {
        $q = "UPDATE nouvelle SET urlImage = :url WHERE id = :id";
        try {
            $r = $this->db->prepare($q);
            $r->execute(array($url, $id));
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }
}