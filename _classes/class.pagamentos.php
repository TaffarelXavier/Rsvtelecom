<?php

class Pagamentos {

    private $conexao = null;

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    /**
     * 
     * @param type $mes
     * @param type $ano
     * @return type
     */
    public function vericarSeExiste($mes, $ano) {

        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM `pagamento` AS t1 WHERE t1.mes = ? AND ano = ?;");
            $stmt->bindParam(1, $mes, PDO::PARAM_STR);
            $stmt->bindParam(2, $ano, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch();

            return $dados[0];
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function pago($mes, $ano) {

        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conexao->prepare("SELECT * FROM `pagamento` AS t1 WHERE t1.mes = ? AND ano = ?;");
            $stmt->bindParam(1, $mes, PDO::PARAM_STR);
            $stmt->bindParam(2, $ano, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch();
            return $dados[3];
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $valor
     * @param type $id
     * @param type $mes
     * @param type $ano
     * @return type
     */
    public function pagar($valor, $id, $mes, $ano) {

        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conexao->prepare("UPDATE `pagamento` SET `pago` = ? "
                    . "WHERE `pagamento`.`id` = ? AND `pagamento`.`mes` = ? AND `pagamento`.`ano` = ?;");
            $stmt->bindParam(1, $valor, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->bindParam(3, $mes, PDO::PARAM_INT);
            $stmt->bindParam(4, $ano, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $file_md5
     * @param type $file_realname
     * @param type $cliente_id
     * @return type
     */
    public function inserir($mes, $ano) {
        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conexao->prepare("INSERT INTO `pagamento` (`id`, `mes`, `ano`, `pago`) VALUES (NULL, ?, ?, 'nao');");
            $stmt->bindParam(1, $mes, PDO::PARAM_INT);
            $stmt->bindParam(2, $ano, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function getPagamentos() {
        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conexao->prepare("SELECT * FROM `pagamento`;");
            $stmt->execute();
            return $stmt;
        } catch (Exception $ex) {
            exit($ex->getMessage());
        }
    }

}
