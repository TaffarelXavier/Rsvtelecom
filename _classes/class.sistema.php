<?php

class Sistema {

    private $conexao = null;

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    public function select() {
        
    }

    public function deletar() {
        
    }

    public function atualiazar() {
        
    }

    public function inserir() {
        try {
            
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function sair() {

        unset($_SESSION["logado"]);

        $expire = time() - 3600;
        
        session_regenerate_id();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', $expire, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        session_destroy();
        header("location: ../../"); 
    }

}