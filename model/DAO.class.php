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

    // Méthode renvoyant toutes les nouvelles correspondant aux filtres
    // $keywords : mots clés, $strict : true si tous les mots clés doivent apparaitre
    // $time : up0 si peu importe, up24 pour les dernières 24h, up7 pour les 7 derniers jours
    //         up30 pour le dernier mois
    public function searchNews(string $keywords, bool $strict, bool $onlyT, string $time) : array {
        // Tableau contenant les nouvelles
        $results = array();

        /* Traitement des mots clés reçus en entrée 
        ======================================================*/
        $keywords = preg_split('/\s+/', $keywords); // On coupe la chaîne par des espaces
        $s_keywords = array();

        /* On reconstruit un tableau et on sécurise chacun des mots clés individuellement */
        foreach ($keywords as $word) {
            if (rtrim($word)) { // Si la chaîne n'est pas vide ou remplie d'espaces
                $s_keywords[] = $this->db->quote("%".$word."%"); // On quote le mot passé en paramètres avec les % (jokers du LIKE)
            }
        }

        try {
            /* Génération de la requête 
            ======================================================*/
            $i = false; $rq = "";
            $mode = ($strict) ? " AND" : " OR"; // Si le mode est strict, on utilise AND, sinon on utilise OR

            foreach ($s_keywords as $word) {
                if (rtrim($word)) { // Si la chaîne n'est pas vide ou remplie d'espaces
                    $str = ($i) ? $mode : ""; // Si il y a plus d'un keyword, on ajoute le mot clé en début de chaîne

                    if ($onlyT) { // Si le mode est "titre only", on ne fait la recherche que sur le titre de la nouvelle
                        $rq .= $str." titre LIKE $word";
                    } else {
                        $rq .= $str." (titre LIKE $word OR description LIKE $word)";
                    }

                    $i = true;
                }
            }
            $q = 'SELECT * FROM nouvelle WHERE'.$rq;

            // Gestion du paramètres temps : AND date >= strftime('%s', 'now', '-1 day') ORDER BY date DESC
            $tabopt = array ("up0" => "", "up24" => "-1 day", "up7" => "-7 day", "up30" => "-1 month");

            // Si le paramètre donné est valide
            if (array_key_exists($time, $tabopt)) {
                if ($time != "up0") {
                    $q .= " AND date >= strftime('%s', 'now', '{$tabopt[$time]}')";
                }
            } else {
                die("Erreur : paramètres invalides : searchNews");
            }

            // On ordonne les résultats par récence
            $q .= ' ORDER BY date DESC';

            // On exécute la requête formée
            $r = $this->db->prepare($q);
            $r->execute();

            $results = $r->fetchAll(PDO::FETCH_CLASS, "Nouvelle");  
    
            return $results;
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    // Méthode de purge des nouvelles d'un flux
    public function purgeRSSFlux($rssID) {
        try {
            $q = 'DELETE FROM nouvelle WHERE RSS_id = :rssID';
            $r = $this->db->prepare($q);
            $r->execute(array($rssID));
        } catch (PDOException $e) {
            die ("PDO Error : ".$e->getMessage());
        }
    }

    // Méthode de suppression d'un flux
    public function deleteRSSFlux($rssID) {
        try {
            /* On supprime dans un premier temps les abonnements utilisant $rssID*/
            $q = 'DELETE FROM abonnement WHERE RSS_id = :rssID';
            $r = $this->db->prepare($q);
            $r->execute(array($rssID));

            /* Puis on supprime les flux RSS */
            $q = 'DELETE FROM RSS WHERE id = :rssID';
            $r = $this->db->prepare($q);
            $r->execute(array($rssID));
        } catch (PDOException $e) {
            die ("PDO Error : ".$e->getMessage());
        }
    }

    // Récupère la liste des flux RSS suivis
    public function getRSSFlux() {
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
    public function createRSS($url, $title) {
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
    public function readRSSfromURL($url) {
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
    
    // Acces à un objet RSS à partir de son ID
    public function readRSSfromID($rssID) {
        try {
            $q = "SELECT * FROM RSS WHERE id = :id";
            $r = $this->db->prepare($q);
            $r->execute(array($rssID));
            $response = $r->fetchAll(PDO::FETCH_CLASS, "RSS");
            if (sizeof($response) > 0){
                return $response[0];
            }           
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    // Met à jour un flux
    public function updateRSS(RSS $rss) {
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
    public function readNouvellefromID($newID,$RSS_id) {
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

    // Récupération de la liste des nouvelles d'un flux RSS (id)
    //  triées de la date la plus récente à la plus ancienne
    public function getAllNews($rssID) {
        try {
            // Si l'ID rss n'est pas spécifié, on prend le premier apparaissant dans la liste
            if ($rssID == -1) {
                $q = 'SELECT * FROM nouvelle WHERE RSS_id IN (SELECT id FROM RSS LIMIT 1) ORDER BY date DESC';         
                $r = $this->db->prepare($q);
                $r->execute();
            } else {
                $q = 'SELECT * FROM nouvelle WHERE RSS_id = :rssID ORDER BY date DESC';                
                $r = $this->db->prepare($q);
                $r->execute(array($rssID));
            }
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

    // Récupération des nouvelles des $nJ derniers jours de chaque flux RSS d'une catégorie donnée
    //  pour un utilisateur donné
    public function getNewsFromCat($username, $cat, $nJ) {
        try {
            $nJ = "-$nJ day";

            $q = "SELECT * FROM nouvelle WHERE RSS_id IN (SELECT RSS_id FROM abonnement WHERE utilisateur_login = :username AND categorie = :cat)
            AND date >= strftime('%s', 'now', :nJ) ORDER BY date DESC";

            $r = $this->db->prepare($q);
            $r->execute(array($username, $cat, $nJ));
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

    // Acces à une nouvelle à partir de son titre et l'ID du flux
    public function readNouvellefromTitre($titre,$RSS_id) {
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
    public function createNouvelle(Nouvelle $n, $RSS_id) {
        $q = "INSERT INTO nouvelle(date, titre, description, url, RSS_id) VALUES (:d, :t, :des, :url, :rss)";
        try {
            $r = $this->db->prepare($q);
            $date = $n->real_date(); // On stocke le timestamp en BDD
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
    public function addImageToNouvelle($url, $id) {
        $q = "UPDATE nouvelle SET urlImage = :url WHERE id = :id";
        try {
            $r = $this->db->prepare($q);
            $r->execute(array($url, $id));
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    //////////////////////////////////////////////////////////
    // Methodes CRUD sur utilisateur
    //////////////////////////////////////////////////////////

    // Cherche un utilisateur sur la db avec son login et renvoie true s'il existe
    public function readUserBool($username) {
        $q = "SELECT * FROM utilisateur WHERE login = :username";
        try {
            $r = $this->db->prepare($q);
            $r->execute(array($username));
            $reply = $r->fetchAll(PDO::FETCH_CLASS,"User");
            return (sizeOf($reply) > 0) ? true : false; 
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    // Crée un compte utilisateur (username, mdp)
    public function create($username, $mdp)
    {
        $q = "INSERT INTO utilisateur VALUES (:username, :mdp)";
        try {
            $r = $this->db->prepare($q);
            $r->execute(array($username, $mdp));
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    public function read($username, $mdp) {
        $q = "SELECT * FROM utilisateur WHERE login = :username";
        if ($this->unlock($username, $mdp)) {
            try {
                $r = $this->db->prepare($q);
                $r->execute(array($username));
                $reply = $r->fetchAll(PDO::FETCH_CLASS,"User");
                return (sizeof($reply) > 0) ? $reply[0] : null;
            } catch (PDOException $e) {
                die("PDO Error : ".$e->getMessage());
            }
        } else {
            return null;
        }
    }
    public function unlock($username, $mdp)
    {
        $q = "SELECT mp FROM utilisateur WHERE login = :username";
        try {
            $r = $this->db->prepare($q);
            $r->execute(array($username));
            $pass = $r->fetch();
            return (password_verify($mdp, $pass['mp'])) ? true : false;
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
    }

    //////////////////////////////////////////////////////////
    // Methodes CRUD sur abonnement
    //////////////////////////////////////////////////////////

    // Crée un abonnement (username, idRSS, nom, cat) si le flux n'est pas
    // déjà enregistré dans la même catégorie
    //   renvoie true si succès
    public function createAbo($username, $idRss, $nom, $cat) : bool
    {
        $result;
    
        try {
            // On vérifie si l'abonnement dans la catégorie n'existe pas déjà en base de données

            $q = "SELECT * FROM abonnement WHERE utilisateur_login = :username AND RSS_id = :idRSS AND categorie = :cat";

            $r = $this->db->prepare($q);
            $r->execute(array($username, $idRss, $cat));
            $pass = $r->fetch();

            $result = ($pass) ? true : false; // On teste si on a un résultat

            // Ajout de l'abonnement dans la base de données

            if (!$result) { // Si le couple abonnement - catégorie n'existe pas déjà
                $q = "INSERT INTO abonnement VALUES (:username, :idRss, :nom, :cat)";
                $r = $this->db->prepare($q);
                $r->execute(array($username, $idRss, $nom, $cat));
            }
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }

        return (!$result);
    }

    // Renvoie tous les abonnements d'un utilisateur sous la forme d'un tableau $tab['categ'] = array (RSS)
    public function getAbo($username) : array
    {
        $result = array();

        try {
            $q = "SELECT categorie, RSS_id FROM abonnement WHERE utilisateur_login = :username ORDER BY categorie";
            $r = $this->db->prepare($q);
            $r->execute(array($username));

            /* On récupères le données sous la forme d'un tableau categorie => tab[RSSid] */
            $result = $r->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);

            /* Pour chaque RSSid d'abonnement, on récupère l'objet RSS correspondant et on remplace l'ID par l'objet */
            foreach ($result as $categ => $tabID) {
                $i = 0;

                /* On parcourt chaque rssID de la catégorie */
                foreach ($tabID as $rssID) {
                    /* On récupère l'objet associé à l'ID et on remplace l'ID par l'objet dans le tableau*/
                    $rssObj = $this->readRSSfromID($rssID);

                    if ($rssObj) {
                        $result[$categ][$i] = $this->readRSSfromID($rssID);
                    }

                    $i++;
                }
            }
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
        
        return $result;
    }

    // Supprime l'abonnement d'un utilisateur à un flux
    // => renvoie true si l'abonnement existait et a été supprimé, false sinon
    public function unsubscribe($username, $rssID) : bool
    {
        try {
            $q = "DELETE FROM abonnement WHERE utilisateur_login = :username AND RSS_id = :rssID;";
            $r = $this->db->prepare($q);
            $result = $r->execute(array($username, $rssID));
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }

        return ($result != 0);
    }

    // Renvoie toutes les catégories auxquelles l'utilisateur est abonné
    public function getAllCat($username) : array
    {
        $result = array();

        try {
            $q = "SELECT categorie FROM abonnement WHERE utilisateur_login = :username GROUP BY categorie";
            $r = $this->db->prepare($q);
            $r->execute(array($username));

            /* On récupère les données sous la forme d'un tableau de catégories */
            $result = $r->fetchAll(PDO::FETCH_COLUMN);

        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }
        
        return $result;
    }
}