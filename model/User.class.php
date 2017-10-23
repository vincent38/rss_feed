<?php

require_once ("DAO.class.php");

class User {

    private $login;
    private $mp;

    function getLogin() {
        return $this->login;
    }

    function getHash() {
        return $this->mp;
    }

    function ajoutAbonnement($idRSS, $nom, $cat) : bool {
        global $dao;

        $status = $dao->createAbo($this->login, $idRSS, $nom, $cat);

        return $status;
    }
}
