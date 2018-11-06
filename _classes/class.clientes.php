<?php

class Clientes {

    private $conexao = null;

    public function __construct($connection) {

        $this->conexao = $connection;
    }

    /**

     * 

     * @param type $username

     * @return type

     */
    public function pesquisar_clientes($username, $tipo = 'nome') {

        try {

            if ($tipo == 'nome') {

                $sth = $this->conexao->prepare('SELECT * FROM `clientes` as t1 WHERE t1.cliente_nome LIKE ?;');
            } else if ($tipo == 'cpf') {

                $sth = $this->conexao->prepare('SELECT * FROM `clientes` as t1 WHERE t1.cliente_cpf = ?;');
            } else {

                exit('Erro interno. 2');
            }



            $sth->bindValue(1, $username, PDO::PARAM_STR);



            $sth->execute();



            return $sth;
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    public function buscar_cliente_por_id($user_id) {

        try {



            $sth = $this->conexao->prepare('SELECT * FROM `clientes` WHERE cliente_id = ?');



            $sth->bindValue(1, $user_id, PDO::PARAM_INT);



            $sth->execute();



            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    public function get_todos_clientes() {

        try {



            $sth = $this->conexao->prepare('SELECT * FROM `clientes`');



            $sth->execute();



            return $sth;
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    /**

     * 

     * @param type $username

     * @return type

     */
    public function contar_pesquisar_clientes($username, $tipo = 'nome') {

        try {



            if ($tipo == 'nome') {

                $sth = $this->conexao->prepare('SELECT COUNT(*) FROM `clientes` as t1 WHERE t1.cliente_nome LIKE ?');
            } else if ($tipo == 'cpf') {

                $sth = $this->conexao->prepare('SELECT COUNT(*) FROM `clientes` WHERE cliente_cpf = ?');
            } else {

                exit("Erro interno!");
            }



            $sth->bindValue(1, $username, PDO::PARAM_STR);



            $sth->execute();



            $total = $sth->fetch();



            return (int) $total[0];
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    /**
     * 
     * @param type $boleto
     * @param type $contar
     * @return type
     */
    public function pesquisar_por_boleto($boleto, $contar = false) {

        try {


            if ($contar == false) {

                $sth = $this->conexao->prepare("SELECT COUNT(*) FROM `boletos` AS t1 JOIN clientes AS t2 ON "
                        . "t1.boleto_cliente_fk_id = t2.cliente_id WHERE boleto_file_realname LIKE ? "
                        . " ORDER BY boleto_id DESC;");
            } else {

                $sth = $this->conexao->prepare("SELECT * FROM `boletos` AS t1 JOIN clientes AS t2 ON "
                        . "t1.boleto_cliente_fk_id = t2.cliente_id WHERE boleto_file_realname LIKE ? "
                        . " ORDER BY boleto_id DESC;");
            }

            $sth->bindValue(1, $boleto, PDO::PARAM_STR);

            $sth->execute();


            if ($contar == false) {

                $total = $sth->fetch();



                return (int) $total[0];
            }

            return $sth;
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    /**
     * 
     * @param type $contar
     * @return type
     */
    public function contar_boletos_pagos($contar = false) {

        try {

            if ($contar == false) {

                $sth = $this->conexao->prepare("SELECT COUNT(*) FROM `boletos` WHERE boleto_pago = 'sim' AND excluido = 'nao' AND boleto_visto_admin = 'nao';");
            } else {

                $sth = $this->conexao->prepare("SELECT * FROM `boletos` AS t1 JOIN clientes AS t2 ON "
                        . "t1.boleto_cliente_fk_id = t2.cliente_id WHERE  boleto_pago = 'sim' AND excluido = 'nao' AND boleto_visto_admin = 'nao' "
                        . " ORDER BY boleto_id DESC;");
            }

            $sth->execute();


            if ($contar == false) {

                $total = $sth->fetch();

                return (int) $total[0];
            }

            return $sth;
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    public function verificar_se_exite_boletos($client_id) {
        try {
            $sth = $this->conexao->prepare('SELECT COUNT(*) FROM `boletos` as t1 WHERE t1.boleto_cliente_fk_id = ?');
            $sth->bindParam(1, $client_id, PDO::PARAM_STR);
            $sth->execute();
            $total = $sth->fetch();
            return (int) $total[0];
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    /**
     * 
     * @param type $valor
     * @param type $data_pago
     * @param type $user_id_pago
     * @param type $visto_admin
     * @param type $boleto_id
     * @return type
     */
    public function marcar_como_pago($valor, $data_pago, $user_id_pago, $visto_admin, $boleto_id) {

        try {



            $sth = $this->conexao->prepare('UPDATE `boletos` SET boleto_pago = ?, `boleto_data_pagamento` = ?, `boleto_usuario_alteracao_fk` =?, `boleto_visto_admin` = ? WHERE boleto_id = ?');



            $sth->bindParam(1, $valor, PDO::PARAM_STR);



            $sth->bindParam(2, $data_pago, PDO::PARAM_STR);



            $sth->bindParam(3, $user_id_pago, PDO::PARAM_STR);



            $sth->bindParam(4, $visto_admin, PDO::PARAM_STR);

            $sth->bindParam(5, $boleto_id, PDO::PARAM_INT);



            $sth->execute();



            return (int) $sth->rowCount();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    /**

     * 

     * @param type $account_id

     * @param type $boleto_id

     * @param type $data

     * @param type $valor

     * @return type

     */
    public function add_log($account_id, $boleto_id, $data, $valor) {

        try {

            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stm = $this->conexao->prepare('INSERT INTO `log_boletos` (`log_id`, `log_account_id`, `log_boleto_id`, `log_data`,`log_tipo`) VALUES (NULL,?,?,?,?);');

            $stm->bindParam(1, $account_id, PDO::PARAM_INT);

            $stm->bindParam(2, $boleto_id, PDO::PARAM_INT);

            $stm->bindParam(3, $data, PDO::PARAM_STR);

            $stm->bindParam(4, $valor, PDO::PARAM_STR);

            $stm->execute();

            return (int) $stm->rowCount();
        } catch (Exception $exc) {

            echo $exc->getMessage();
        }
    }

    /**

     * 

     * @param type $boleto_id

     * @return type

     */
    public function buscar_boleto_por_id($boleto_id) {

        try {



            $sth = $this->conexao->prepare('SELECT * FROM `boletos` WHERE boleto_id = ? LIMIT 1;');



            $sth->bindValue(1, $boleto_id, PDO::PARAM_STR);



            $sth->execute();



            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    /*
     * 
     */

    public function marcar_como_visto($sql) {

        try {

            $sth = $this->conexao->prepare($sql);
            $sth->execute();
            return (int) $sth->rowCount();
        } catch (PDOException $exc) {

            echo $exc->getMessage();
        }
    }

    public function buscar_boletos_por_cliente_id($client_id) {

        try {



            $sth = $this->conexao->prepare('SELECT * FROM `boletos` as t1 WHERE t1.boleto_cliente_fk_id = ? ORDER BY boleto_id DESC;');



            $sth->bindParam(1, $client_id, PDO::PARAM_STR);



            $sth->execute();



            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    /**

     * 

     * @param type $cliente_id

     * @return type

     */
    public function excluir_cliente($cliente_id) {

        try {

            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conexao->prepare('DELETE FROM `clientes` WHERE cliente_id = ?');

            $stmt->bindParam(1, $cliente_id, PDO::PARAM_INT);

            $stmt->execute();

            return (int) $stmt->rowCount();
        } catch (Exception $exc) {

            echo $exc->getMessage();
        }
    }

    /**

     * 

     * @param type $nome

     * @param type $cpf

     */
    public function adicionar_cliente($nome, $cpf) {

        try {

            try {

                $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $this->conexao->prepare('INSERT INTO `clientes` (`cliente_id`, `cliente_nome`, `cliente_cpf`) VALUES (NULL,?,?);');

                $stmt->bindParam(1, $nome, PDO::PARAM_STR);

                $stmt->bindParam(2, $cpf, PDO::PARAM_STR);

                $stmt->execute();

                return (int) $stmt->rowCount();
            } catch (Exception $exc) {

                echo $exc->getMessage();
            }
        } catch (Exception $exc) {

            echo $exc->getMessage();
        }
    }

    /**

     * 

     * @param type $cpf

     * @return type

     */
    public function verificar_se_cpf_existe($cpf) {

        try {



            $sth = $this->conexao->prepare('SELECT COUNT(*) FROM `clientes` WHERE cliente_cpf = ?');



            $sth->bindValue(1, $cpf, PDO::PARAM_STR);



            $sth->execute();



            $total = $sth->fetch();



            return $total[0];
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

    public function alterar_cliente($cliente_nome, $cliente_cpf, $cliente_id) {

        try {



            $sth = $this->conexao->prepare('UPDATE `clientes` SET `cliente_nome` = ?, `cliente_cpf` = ?  WHERE `clientes`.`cliente_id` = ?;');



            $sth->bindValue(1, $cliente_nome, PDO::PARAM_STR);



            $sth->bindValue(2, $cliente_cpf, PDO::PARAM_STR);



            $sth->bindValue(3, $cliente_id, PDO::PARAM_INT);



            $sth->execute();



            return (int) $sth->rowCount();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

}
