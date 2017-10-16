<?php

class User {

    private $login;
    private $mp;

    function getLogin() {
        return $this->login;
    }

    function getHash() {
        return $this->mp;
    }
}
