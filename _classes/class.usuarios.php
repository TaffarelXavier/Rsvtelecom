<?php

class Usuarios {

    private $conexao = null;

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function get_usuario_por_id($id) {
        try {

            $sth = $this->conexao->prepare('SELECT conta_id,conta_usuario,conta_nivel FROM `conta` WHERE conta_id = ? LIMIT 1;');

            $sth->bindValue(1, $id, PDO::PARAM_INT);

            $sth->execute();

            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * 
     * @param type $id O id do usuário
     * @return type
     */
    public function excluir_usuario_permanentemente($id) {
        try {

            $sth = $this->conexao->prepare('DELETE FROM `conta` WHERE conta_id = ?');

            $sth->bindValue(1, $id, PDO::PARAM_STR);

            $sth->execute();
            
            return (int) $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function atualiazar() {
        
    }

    public function gerar_hash($senha) {
        $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);

        $hash = password_hash($senha, PASSWORD_BCRYPT, array("cost" => 14, "salt" => $salt));

        return $hash;
    }

    public function conta_existe($username) {
        try {

            $sth = $this->conexao->prepare('SELECT COUNT(*) FROM `conta` WHERE conta_usuario = ?');

            $sth->bindValue(1, $username, PDO::PARAM_STR);

            $sth->execute();

            $total = $sth->fetch();

            return $total[0];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function alterar_senha($nova_senha, $conta_id) {
        try {

            $hash = $this->gerar_hash($nova_senha);

            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->conexao->prepare('UPDATE `conta` SET conta_senha = ? WHERE conta_id = ?;');
            $stmt->bindParam(1, $hash, PDO::PARAM_STR);
            $stmt->bindParam(2, $conta_id, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $novo_nome_usuario
     * @param type $tipo_de_usuario
     * @param type $conta_id
     * @return type
     */
    public function alterar_nome_usuario($novo_nome_usuario, $tipo_de_usuario, $conta_id) {
        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->conexao->prepare('UPDATE `conta` SET conta_usuario = ? , `conta_nivel` = ? WHERE conta_id = ?;');
            $stmt->bindParam(1, $novo_nome_usuario, PDO::PARAM_STR);
            $stmt->bindParam(2, $tipo_de_usuario, PDO::PARAM_STR);
            $stmt->bindParam(3, $conta_id, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $nome
     * @param type $senha
     * @param type $nivel
     * @return type
     */
    public function adicionar_usuario($nome, $senha, $nivel) {
        try {


            $hash = $this->gerar_hash($senha);

            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->conexao->prepare('INSERT INTO `conta` (`conta_id`, `conta_usuario`, `conta_senha`, `conta_nivel`) VALUES (NULL,?,?,?);');
            $stmt->bindParam(1, $nome, PDO::PARAM_STR);
            $stmt->bindParam(2, $hash, PDO::PARAM_STR);
            $stmt->bindParam(3, $nivel, PDO::PARAM_STR);
            $stmt->execute();
            return (int) $stmt->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $usuario
     * @param type $senha
     */
    public function login($usuario, $senha) {
        try {

            $sth = $this->conexao->prepare('SELECT * FROM `conta` WHERE conta_usuario = ?');

            $sth->bindValue(1, $usuario, PDO::PARAM_STR);

            $sth->execute();

            $dados = $sth->fetch(PDO::FETCH_ASSOC);

            if (password_verify($senha, $dados['conta_senha'])) {
                $_SESSION['logado'] = true;
                $_SESSION['tx_dados_usuario'] = array('conta_id' => $dados['conta_id'], 'conta_usuario' => $dados['conta_usuario'], 'conta_nivel' => $dados['conta_nivel']);
                return true;
            }
            return false;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
