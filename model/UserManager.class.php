<?php

require_once('DAO.class.php');
require_once('User.class.php');

class UserManager {
    public function register($username, $mdp) : bool
    {
        // Objet DAO
        $dao = new DAO();
        
        $mdp = password_hash($mdp, PASSWORD_BCRYPT);
        $reply = $dao->readUserBool($username);

        // Si un utilisateur du même nom existe, on annule l'enregistrement
        if ($reply) {
            return false;
        } else {
            $dao->create($username, $mdp);
            return true;
        }
    }

    public function login($username, $mdp)
    {
        // Objet DAO
        $dao = new DAO();
        $reply = $dao->read($username, $mdp);
        if ($reply == null) {
            return null;
        } else {
            return null;
        }
    }
}
