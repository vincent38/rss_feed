<?php
/* On crée une instance de DAO pour tout le programme */

$dao = new DAO();

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
    public function searchNews(array $keywords, bool $strict, bool $onlyT, string $time) : array {
        // Tableau contenant les nouvelles
        $results = array();

        /* Traitement des mots clés reçus en entrée 
        ======================================================*/
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
    public function purgeRSSFlux($rssID, $upT = -1) {
        try {
            // On ajoute un filtre éventuel sur la date
            $filter_date = ($upT != -1) ? " AND date <= strftime('%s', 'now', '-$upT day')" : "";

            $q = 'DELETE FROM nouvelle WHERE RSS_id = :rssID'.$filter_date;
            $r = $this->db->prepare($q);
            $r->execute(array($rssID));
        } catch (PDOException $e) {
            die ("PDO Error : ".$e->getMessage());
        }
    }

    // Méthode de suppression d'un flux
    public function deleteRSSFlux($rssID) {
        try {
            /* On supprime dans un premier temps les abonnements utilisant $rssID */
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
    // Renvoie l'objet RSS créé
    public function createRSS($url, $title) {
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
    public function getAllNews($rssID, $upT = -1) {
        try {
            // On ajoute la query string de filtrage
            $filter = $this->getFilterQuery();

            // Si $upT est différent de -1, on ajoute un filtre sur la date
            $filter_date = ($upT != -1) ? " AND date <= strftime('%s', 'now', '-$upT day')" : "";

            // Si l'ID rss n'est pas spécifié, on prend le premier apparaissant dans la liste
            if ($rssID == -1) {
                $q = 'SELECT * FROM nouvelle WHERE RSS_id IN (SELECT id FROM RSS LIMIT 1) '.$filter.' '.$filter_date.' ORDER BY date DESC';  
                $r = $this->db->prepare($q);
                $r->execute();
            } else {
                $q = 'SELECT * FROM nouvelle WHERE RSS_id = :rssID '.$filter.' '.$filter_date.' ORDER BY date DESC';                
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

    // Récupération de la liste des nouvelles d'un flux RSS (id)
    //  triées de la date la plus récente à la plus ancienne
    public function getAllMixedNews($opt_time) {
        try {
            // On ajoute la query string de filtrage
            $filter = $this->getFilterQuery();

            // On construit le filtre sur la date
            $opt_query =  array ("ajd" => " date >= strftime('%s', 'now', '-1 day')",
                                "week" => " date >= strftime('%s', 'now', '-7 day') AND date < strftime('%s', 'now', '-1 day')",
                                "all"  => " date >= strftime('%s', 'now', '-1 year') AND date < strftime('%s', 'now', '-7 day')");
    
            $filter_date = $opt_query[$opt_time];

            $q = 'SELECT * FROM nouvelle WHERE '.$filter_date.' '.$filter.' ORDER BY date DESC';                
            $r = $this->db->prepare($q);
            $r->execute();

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

    // Récupération de tous les mots de la base de donnée classés par ordre de fréquence
    //  triées de la date la plus récente à la plus ancienne
    //  renvoie un tableau de la forme : array (nbOccurences => "mot") trié par nbOccurences
    //  $nbJ : date de la plus vieille nouvelle à considérer en jours, 365 par défaut
    //  $nbMots : nombre de mots à lister, 30 par défaut
    public function getAllWords($nbJ = 365, $nbMots = 30) : array {
        $stat_array = array();

        try {
            // On reformate le nombre de jours
            $nbJ = "-$nbJ day";
            $q = "SELECT description, titre FROM nouvelle WHERE date >= strftime('%s', 'now', '$nbJ')";            
            $r = $this->db->prepare($q);
            $r->execute();

            // On récupère toutes les descriptions
            $response = $r->fetchAll(PDO::FETCH_COLUMN);

            // Si le résultat est vide on retourne un array vide
            if (!$response) return $stat_array;

            // On crée une longue chaîne de toutes les descriptions
            $allText = "";
            foreach ($response as $description) {
                // On supprime toute la ponctuation brouillant les statistiques
                $allText .= " ".$description;
            }

            // On supprime toutes les balises HTML
            $allText = strip_tags($allText);

            // On enlève les smart quotes et autres caractères spéciaux
            $allText = preg_replace("/[\u{2019}]/", " ", $allText);
            $allText = preg_replace("/[\u{0022}]/", " ", $allText);
            $allText = preg_replace("/[\u{0027}]/", " ", $allText);
            $allText = preg_replace("/[\u{0060}]/", " ", $allText);

            // On supprime les nbsp (seule solution ne plaçant pas des caractères erronés dans la chaîne)
            $allText = hex2bin(str_replace('c2a0', '20', bin2hex($allText)));

            $allText = str_replace(array(".", ",", "«", "»", "(", ")"), " ", $allText);

            // On enlève les tabulations\entrées
            $allText = str_replace(array("\r", "\t", "\n"), " ", $allText);

            // On découpe la chaîne par espaces
            $allText = explode(" ", $allText);

            // On enlève les mots les plus fréquents ayant peu de valeur pour ce genre de statistiques
            // => http://eduscol.education.fr/cid47916/liste-des-mots-classee-par-frequence-decroissante.html
            // le contenu du site a été parsé avec un script JS écrit à l'occasion
            $frequent = "le de un être et à il avoir ne je son que est se qui ce au aux dans été en du elle ils il au de ce des ans en tous mes leur leurs ses les pour pas que un une vous par sur faire plus dire me on mon lui".
            " nous comme mais pouvoir avec tout y aller voir en bien où sans tu ou leur homme était si deux mari moi je vous tu moi nous vouloir te femme venir quand grand celui si notre devoir"
            ." là jour prendre même votre tout rien petit encore aussi quelque dont tout mer trouver donner lors temps ça peu même falloir sous parler alors main chose ton mettre"
            ." vie savoir yeux passer autre après regarder toujours puis jamais cela ces cette celle celui qui aimer non heure croire cent monde donc jusqu enfant fois seul autre entre vers chez demander jeune"
            ." jusque très moment rester répondre tout tête père fille avait mille premier car entendre ni bon trois cœur ainsi an quatre un terre contre monsieur voix penser quel"
            ." arriver maison devant coup beau connaître devenir air mot nuit sentir eau vieux sembler moins tenir ici comprendre oui rendre toi vingt depuis attendre sortir ami trop"
            ." porte lequel chaque amour pendant déjà pied tant gens parce que nom vivre reprendre entrer porter pays ciel avant frère regard chercher âme côté mort revenir noir maintenant"
            ." nouveau ville rue enfin appeler soir chambre mourir pas partir cinq esprit soleil dur ont dernier jeter dix roi état corps beaucoup suivre bras écrire blanc montrer tomber"
            ." place ouvrir ah parti assez leur cher voilà année loin point visage bruit lettre franc fond force arrêter perdre commencer paraître aucun marcher milieu saint idée presque"
            ." ailleurs travail lumière long seulement mois fils neuf tel lever raison effet gouvernement permettre pauvre asseoir point plein personne vrai peuple fait parole guerre toute"
            ." écouter pensée affaire quoi matin pierre monter bas vent doute front ombre part maître aujourd'hui besoin question apercevoir recevoir mieux peine tour servir oh autour "
            ."près finir famille pourquoi souvent rire dessus madame sorte figure droit peur bout lieu silence gros chef ferme eh six bois mari histoire crier jouer feu tourner doux "
            ."longtemps fort heureux comme garder partie face mouvement fin reconnaître quitter personne notamment comment route dès manger livre"
            ."premier second troisième quatrième cinquième sixième septième huitième neuvième onzième douzième"
            ." doit devra devrait devrez doivent devait malgré sont sommes étiez êtes";

            $frequent .= " lundi mardi mercredi jeudi vendredi samedi dimanche"; // => éventuellement
            $frequent .= " janvier février mars avril mai juin juille aout septembre octobre novembre décembre"; // => éventuellement

            $frequent = explode (" ", $frequent);
            
            // On ne garde que les éléments contenant au moins cinq caractères et n'appartenant pas à la liste des mots fréquents
            $newText = array();
            foreach ($allText as $word) {
                $lower = strtolower($word);
                if ((strlen($lower) >= 5) && (!in_array($lower, $frequent))) {
                    $newText[] = $lower;
                }
            }

            // On compte le nombre d'occurences de chaque mot et on les trie
            foreach ($newText as $word) {
                if (isset($stat_array[$word])) {
                    $stat_array[$word]++;
                } else {
                    $stat_array[$word] = 1;
                }
            }

            arsort($stat_array);

            // On ne retient que les 30 mots les plus présents
            $stat_array = array_slice($stat_array, 0, 30);

        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }

        return $stat_array;
    }

    // Récupération des nouvelles des $nJ derniers jours de chaque flux RSS d'une catégorie donnée
    //  pour un utilisateur donné
    public function getNewsFromCat($username, $cat, $nJ) {
        try {
            $nJ = "-$nJ day";

            // On ajoute la query string de filtrage
            $filter = $this->getFilterQuery();

            $q = "SELECT * FROM nouvelle WHERE RSS_id IN (SELECT RSS_id FROM abonnement WHERE utilisateur_login = :username AND categorie = :cat)
            AND date >= strftime('%s', 'now', :nJ) $filter ORDER BY date DESC";

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

            // On ajoute la query string de filtrage
            $q .= $this->getFilterQuery();

            $r = $this->db->prepare($q);
            $r->execute(array($titre, $RSS_id));
            $response = $r->fetchAll(PDO::FETCH_CLASS, "Nouvelle");
            if (sizeof($response) > 0) {
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

    /* Fonctions liées au système de filtrage par mots clés
    ================================================================================================================== */

    // Met à jour les mots clés filtrés de l'utilisateur
    // => crée l'entrée si elle n'existe pas
    public function update_word_filter($username, $new_chain) : bool
    {
        $result = true;

        try {
            $filter_chain = $this->getFilterChain($username);

            /* Si elle n'existe pas, on en crée une nouvelle */
            if (!$filter_chain) {
                $q = 'INSERT INTO word_filters (utilisateur_login,filter_chain) VALUES (:username,:new_chain)';
                $r = $this->db->prepare($q);
                $r->execute(array($username, $new_chain));

                $result = $r;

            } else { // Si une chaîne a déjà été enregistrée et qu'elle est différente de la nouvelle, on la met à jour
                if ($filter_chain != $new_chain) {
                    $q = "UPDATE word_filters SET filter_chain = :new_chain WHERE utilisateur_login = :username";
                    $r = $this->db->prepare($q);
                    $r->execute(array($new_chain, $username));

                    $result = $r;
                }
                // => sinon on ne fait rien
            }
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }

        return ($result ? true : false);
    }

    // Supprime la chaîne filtre de l'utilisateur $username de la base de données
    public function removeFilterChain($username) {
        try {
            $q = 'DELETE FROM word_filters WHERE utilisateur_login = :username';
            $r = $this->db->prepare($q);
            $r->execute(array($username));
        } catch (PDOException $e) {
            die ("PDO Error : ".$e->getMessage());
        }
    }

    // Renvoie la chaîne filtre de l'utilisateur $username si elle existe
    // une chaîne vide sinon
    public function getFilterChain($username) : string
    {
        try {
            $q = "SELECT filter_chain FROM word_filters WHERE utilisateur_login = :username";
            $r = $this->db->prepare($q);
            $r->execute(array($username));

            $result = $r->fetch();

        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }

        return ($result ? $result[0] : "");
    }

    // Renvoie la requête appliquant les filtres utilisateur
    // ou une chaîne vide si l'utilisateur est connecté
    //   => opt est à false s'il faut exclure les nouvelles contenant les mots
    //                true s'il faut autoriser uniquement les nouvelles contenant les mots
    public function getFilterQuery($opt = false) : string 
    {
        require_once("../model/User.class.php");

        $rq = "";

        // On démarre la session si elle n'est pas déjà lancée
        if (session_status() == PHP_SESSION_NONE) session_start();

        // Si l'utilisateur est connecté
        if (isset($_SESSION["user"]) && $_SESSION["user"] !== null) {
            // On récupère tous la filter chain de l'utilisateur connecté
            $filter_chain = $this->getFilterChain($_SESSION["user"]->getLogin());

            // Si la chaîne est non vide, on crée une query string à partir des mots clés
            if ($filter_chain) {
                $filters = explode(",", $filter_chain);

                // Hack rapide pour éviter d'avoir à gérer les cas ou la requête commence ou termine par "OR"
                if ($opt) $rq = " AND (0=1 ";

                foreach ($filters as &$word) {
                    if (rtrim($word)) { // Si la chaîne n'est pas vide ou remplie d'espaces
                        // On quote les mots clés en ajoutant les jokers
                        $word = $this->db->quote("%".$word."%");

                        // On ajoute la query string selon le mode d'appel
                        if ($opt) {
                            $rq .= " OR (titre LIKE $word OR description LIKE $word)";
                        } else {
                            $rq .= " AND NOT (titre LIKE $word OR description LIKE $word)";
                        }
                    }
                }

                if ($opt) $rq .= ")";
            }
        }

        return $rq;
    }

    // Renvoie total de nouvelles dans la base filtrées par les mots clés
    // et le nom des flux les plus bloqués
    // sous la forme d'un array ("nomRSS" => "nom du flux le plus bloqué", "nbRSS" => "nombre d'articles bloqués du flux", "nbTot" => "nombre total de nouvelles bloquées")
    public function getFilterStats($username) : array {
        $result = array();

        try {
            // On récupère la query string de filtrage
            $filter_q = $this->getFilterQuery(true);

            // Si l'utilisateur utilise des filtres
            if ($filter_q) {
                // La requête ressemble à quelque chose comme ça avec "ministre"
                // SELECT COUNT(*) AS nbBlock, RSS_id FROM nouvelle WHERE RSS_id > -1 AND (titre LIKE '%ministre%' OR description LIKE '%ministre%') GROUP BY RSS_id ORDER BY nbBlock DESC
                $q = 'SELECT COUNT(*) AS nbBlock, RSS_id FROM nouvelle WHERE RSS_id > -1 '.$filter_q. ' GROUP BY RSS_id ORDER BY nbBlock DESC';
                $r = $this->db->prepare($q);
                $r->execute(array());

                $response = $r->fetchAll();

                /* On formate le tableau de retour, s'il y a des résultats à la requête */
                if ($response) {
                    // Calcul du nombre total de nouvelles bloquées
                    $totalNB = 0;
                    foreach ($response as $qRow) {
                        $totalNB += $qRow["nbBlock"];
                    }
                    $result['nbTot'] = $totalNB;

                    // On récupère le nom du flux le plus bloqué
                    $result['nomRSS'] = $this->readRSSfromID($response[0]['RSS_id'])->titre();
                    $result['nbRSS'] = $response[0]['nbBlock'];
                }
            }
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }

        return $result;
    }

    /* Fonctions liées au système de filtrage HTML
    ================================================================================================================== */

    // Met à jour les balises HTML filtrées de l'utilisateur
    // => crée l'entrée si elle n'existe pas
    public function update_HTML_filter($username, $new_chain) : bool
    {
        $result = true;

        try {
            $filter_chain = $this->getHTMLFilter($username);

            /* Si les filtres n'existent pas, on en crée de nouveaux */
            if (!$filter_chain) {
                $q = 'INSERT INTO html_filters (utilisateur_login,filtered_tags) VALUES (:username,:new_chain)';
                $r = $this->db->prepare($q);
                $r->execute(array($username, $new_chain));

                $result = $r;

            } else { // Si une chaîne a déjà été enregistrée et qu'elle est différente de la nouvelle, on la met à jour
                if ($filter_chain != $new_chain) {
                    $q = "UPDATE html_filters SET filtered_tags = :new_chain WHERE utilisateur_login = :username";
                    $r = $this->db->prepare($q);
                    $r->execute(array($new_chain, $username));

                    $result = $r;
                }
                // => sinon on ne fait rien
            }
        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }

        return ($result ? true : false);
    }

    // Renvoie les filtres HTML de l'utilisateur $username s'il en a
    // une chaîne vide sinon
    public function getHTMLFilter($username) : string
    {
        try {
            $q = "SELECT filtered_tags FROM html_filters WHERE utilisateur_login = :username";
            $r = $this->db->prepare($q);
            $r->execute(array($username));

            $result = $r->fetch();

        } catch (PDOException $e) {
            die("PDO Error : ".$e->getMessage());
        }

        return ($result ? $result[0] : "");
    }

    // Supprime les filtres HTML de l'utilisateur $username de la base de données
    public function removeHTMLFilter($username) {
        try {
            $q = 'DELETE FROM html_filters WHERE utilisateur_login = :username';
            $r = $this->db->prepare($q);
            $r->execute(array($username));
        } catch (PDOException $e) {
            die ("PDO Error : ".$e->getMessage());
        }
    }
}