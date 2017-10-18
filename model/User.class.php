<?php

require_once "DAO.class.php";

class User {

    private $login;
    private $mp;

    function getLogin() {
        return $this->login;
    }

    function getHash() {
        return $this->mp;
    }

    function ajoutAbonnement($idRss, $nom, $cat) : bool {
        $dao = new DAO;
        $status = $dao->createAbo($this->login, $idRss, $nom, $cat);

        return $status;
    }
}
