<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Usuarios = new Usuarios($connection);

    $nome = trim(val_input::sani_string('nome'));

    $conta_nome = trim(val_input::sani_string('conta_nome'));

    $cpf = val_input::sani_string('senha');

    $tipo_de_conta = val_input::sani_string('tipo_de_conta');

    $tipo_altr = val_input::sani_string('tipo_altr');

    $usuario_id = val_input::sani_string('usuario_id');

    switch ($tipo_altr) {
        case '1':
            /*Se os dados dos dois campos forem iguais*/
            if ($nome === $conta_nome) {
                echo $Usuarios->alterar_nome_usuario($nome,$tipo_de_conta,$usuario_id) > 0 ? '1' : '0';
            }
            else{
              if ($Usuarios->conta_existe($nome) > 0) {
                    exit("A conta [" . $nome . "] já existe.");
                } else if ($nome == "" || empty($nome) || $nome == false) {
                    exit("Nome de usuário incorreto.");
                } else {
                    echo $Usuarios->alterar_nome_usuario($nome,$tipo_de_conta,$usuario_id) > 0 ? '1' : '0';
                }  
            }

            break;
        case '2':
            $senha1 = trim(val_input::sani_string('senha1'));

            $senha2 = trim(val_input::sani_string('senha2'));
  
            if (empty($senha1) || empty($senha2)) {
                exit('A nova senha está em branco.');
            } else if ($senha1 !== $senha2) {
                exit('As senhas são diferentes.');
            } else {
                echo $Usuarios->alterar_senha($senha2, $usuario_id) > 0 ? '1' : '0';
            }

            break;
    }
}