<?php

class Configuracoes {

    private $conexao = null;

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    /**
     * 
     * @param type $config_id
     * @return type
     */
    public function get_config($config_id, $cols = '') {
        try {

            $cols = $cols == '' ? '*' : $cols;

            $sth = $this->conexao->prepare('SELECT ' . $cols . ' FROM `configuracoes` WHERE config_id = ? order by config_id desc LIMIT 1;');

            $sth->bindValue(1, $config_id, PDO::PARAM_INT);

            $sth->execute();

            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function deletar() {
        
    }

    /**
     * 
     * @param type $telefone
     * @param type $config_id
     * @return type
     */
    public function atualiazar($telefone, $config_id) {
        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stm = $this->conexao->prepare('UPDATE `configuracoes` SET telefone = ? WHERE config_id = ?');
            $stm->bindParam(1, $telefone, PDO::PARAM_STR);
            $stm->bindParam(2, $config_id, PDO::PARAM_STR);
            $stm->execute();
            return (int) $stm->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $font_family
     * @param type $font_size
     * @param type $config_id
     * @return type
     */
    public function update_configuracoes($font_family, $font_size, $config_id) {
        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stm = $this->conexao->prepare('UPDATE `configuracoes` SET `fonte_family` = ?, `fonte_size` = ? WHERE `configuracoes`.`config_id` = ?;');
            $stm->bindParam(1, $font_family, PDO::PARAM_STR);
            $stm->bindParam(2, $font_size, PDO::PARAM_STR);
            $stm->bindParam(3, $config_id, PDO::PARAM_INT);
            $stm->execute();
            return (int) $stm->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
