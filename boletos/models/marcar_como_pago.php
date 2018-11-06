<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Clientes = new Clientes($connection);

    $boleto_id = val_input::val_int('boleto_id');

    $valor = val_input::sani_string('valor');

    $n = $valor == 'nao' ? '' : time();

    $user_id = $_SESSION['tx_dados_usuario']['conta_id'];

    /* SE FOR USUÁRIO PADRÃO SOMENTE SIM */
    if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'padrao') {

        $dr = $Clientes->buscar_boleto_por_id($boleto_id);

        if ($dr['boleto_pago'] == 'nao') {
            echo $Clientes->marcar_como_pago('sim', time(), $user_id, 'nao', $boleto_id) > 0 ? '1' : '0';
            $Clientes->add_log($user_id, $boleto_id, time(), 'sim');
        }
    } else {
        /* SE FOR USUÁRIO ADMINISTRADOR SIM OU NÃO */
        echo $Clientes->marcar_como_pago($valor, $n, $user_id, 'nao', $boleto_id) > 0 ? '1' : '0';
        $Clientes->add_log($user_id, $boleto_id, time(), $valor);
    }
}