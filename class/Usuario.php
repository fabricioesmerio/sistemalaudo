<?php


class Usuario {
    
    private $codlogin;
    private $login;
    private $cryptsenha;
    private $codusuario;
    private $bloqueado;
    
    function getId() {
        return $this->codlogin;
    }

    function getLogin() {
        return $this->login;
    }

    function getPass() {
        return $this->cryptsenha;
    }

    function getCodUsuario() {
        return $this->codusuario;
    }

    function getBloqueado() {
        return $this->bloqueado;
    }

    function setId($id) {
        $this->codlogin = $id;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setPass($pass) {
        $this->cryptsenha = $pass;
    }

    function setCodUsuario($codusuario) {
        $this->codusuario = $codusuario;
    }

    function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }


    
}
