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

    function ajoutAbonnement($idRss, $nom, $cat) {
        $dao = new DAO;
        $dao->createAbo($this->login, $idRss, $nom, $cat);
    }
}
