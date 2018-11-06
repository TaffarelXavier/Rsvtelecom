<?php

class Contas {

    private $conexao = null;

    public function __construct($connection) {
        $this->conexao = $connection;
    }
    public function deletar() {
        
    }

    public function atualiazar() {
        
    }
    public function get_todas_contas() {
        try {

            $sth = $this->conexao->prepare('SELECT * FROM `conta`');

            $sth->execute();

            return $sth;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    
    }


    public function inserir() {
        try {
            
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
