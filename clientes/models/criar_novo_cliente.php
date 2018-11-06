<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Clientes = new Clientes($connection);

    $nome = val_input::sani_string('nome');

    $cpf = val_input::sani_string('cpf');

    $tipo_cliente = val_input::sani_string('tipo_cliente');

    switch ($tipo_cliente) {
        case 'cpf':

            if (val_input::validaCPF(preg_replace('/\.|\-/ui', '', $cpf))) {

                if ($Clientes->verificar_se_cpf_existe($cpf) > 0) {
                    exit('O cpf,' . $cpf . ' já existe.');
                } else {
                    echo $Clientes->adicionar_cliente($nome, $cpf) > 0 ? '1' : '0';
                }
            } else {
                echo 'O CPF está incorreto.';
            }

            break;

        case 'cnpj':

                /*Vale também para verificar o CNPJ*/
                if ($Clientes->verificar_se_cpf_existe($cpf) > 0) {
                    exit('O CNPJ,' . $cpf . ', já existe.');
                } else {
                    echo $Clientes->adicionar_cliente($nome, $cpf) > 0 ? '1' : '0';
                }
            
            break;
    }
}