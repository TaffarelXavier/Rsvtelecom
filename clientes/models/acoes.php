<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Clientes = new Clientes($connection);

    $nome = val_input::sani_string('nome');

    $cpf = val_input::sani_string('cpf');

    $acao = val_input::sani_string('acao');

    $tipo_cliente = val_input::sani_string('tipo_cliente');

    switch ($acao) {
        case 'insert':

            if (val_input::validaCPF(preg_replace('/\.|\-/ui', '', $cpf))) {
                echo $Clientes->adicionar_cliente($nome, $cpf) > 0 ? '1' : '0';
            } else {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="alert alert-danger">
                            <strong>O CPF</strong> está incorreto.
                        </div>
                    </div>
                </div>
                <?php
            }
            break;
        case 'delete':

            $cliente_id = val_input::val_int('cliente_id');

            echo $Clientes->excluir_cliente($cliente_id) > 0 ? '1' : '0';

            break;

        case 'update':

            $cliente_id = val_input::val_int('cliente_id');

            $cpf2 = val_input::sani_string('cpf2');


            if (val_input::validaCPF(preg_replace('/\.|\-/ui', '', $cpf))) {

                /* Verifica a igualdade entre os CPF */
                /* if ($cpf == $cpf2) {
                  if ($Clientes->verificar_se_cpf_existe($cpf) > 1) {
                  exit('O CPF já existe 1 ');
                  }
                  } else {
                  if ($Clientes->verificar_se_cpf_existe($cpf) > 0) {
                  exit('O CPF já existe 2 ');
                  }
                  }
                 */
                echo $Clientes->alterar_cliente($nome, $cpf, $cliente_id) > 0 ? '1' : '0';

                /* if ($Clientes->verificar_se_cpf_existe($cpf) == '0') {
                  echo $Clientes->alterar_cliente($nome, $cpf, $cliente_id) > 0 ? '1' : '0';
                  } else if ($Clientes->verificar_se_cpf_existe($cpf) == '0') {
                  echo $Clientes->alterar_cliente($nome, $cpf, $cliente_id) > 0 ? '1' : '0';
                  } else {
                  exit('O CPF já existe na base de dados.');
                  } */
            } else {
               echo $Clientes->alterar_cliente($nome, $cpf, $cliente_id) > 0 ? '1' : '0';
            }
            break;
    }
}