<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Boletos = new Boletos($connection);

    $boleto_id = val_input::val_int('boleto_id');

    echo $Boletos->excluir_boleto_por_id($boleto_id,'sim') > 0 ? '1' : '0';
}
