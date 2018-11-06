<?php

class Boletos {

    private $conexao = null;

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    public function select() {
        
    }

   /**
    * <p>Excluir um boleto pelo seu ID.</p>
    * @param type $boleto_id
    * @param type $valor
    * @return type
    */
    public function excluir_boleto_por_id($boleto_id,$valor) {
        try {

            $sth = $this->conexao->prepare('UPDATE `boletos` SET `excluido` = ? WHERE `boletos`.`boleto_id` = ?;');

            $sth->bindValue(1, $valor, PDO::PARAM_STR);
            
            $sth->bindValue(2, $boleto_id, PDO::PARAM_INT);

            $sth->execute();

            return (int) $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


    /**
     * 
     * @param type $file_md5
     * @param type $file_realname
     * @param type $cliente_id
     * @return type
     */
    public function inserir($file_md5, $file_realname, $cliente_id) {
        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conexao->prepare("INSERT INTO `boletos` (`boleto_id`, `boleto_file_md5`, "
                    . "`boleto_file_realname`, `boleto_cliente_fk_id`, `boleto_pago`) VALUES (NULL,?,?,?,'nao');");
            $stmt->bindParam(1, $file_md5, PDO::PARAM_STR);
            $stmt->bindParam(2, $file_realname, PDO::PARAM_STR);
            $stmt->bindParam(3, $cliente_id, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_logs_boletos() {
        try {

            $sth = $this->conexao->prepare('SELECT log_id, conta_id,log_data,log_boleto_id,conta_usuario FROM '
                    . '`log_boletos` AS t1 JOIN conta AS t2 ON t1.log_account_id = t2.conta_id WHERE log_tipo ="sim" ORDER BY log_data DESC;');

            $sth->execute();

            return $sth;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        }


}
