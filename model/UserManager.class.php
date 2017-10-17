<?php

require_once('DAO.class.php');
require_once('User.class.php');

class UserManager {
<<<<<<< HEAD

    public function register($username, $mdp)
=======
    public function register($username, $mdp) : bool
>>>>>>> 112f371c4015667c2000e05237c31f967d4e9d89
    {
        // Objet DAO
        $dao = new DAO();
        $mdp = password_hash($mdp, PASSWORD_BCRYPT);
        $reply = $dao->readUserBool($username);
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
            return $reply;
        }
    }
}
