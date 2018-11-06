<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../../autoload.php';

    $pg = new Pagamentos($connection);

    $id = val_input::val_int('id');

    $mes = val_input::val_int('mes');

    $ano = val_input::val_int('ano');
    
    echo $pg->pagar('sim', $id, $mes, $ano) > 0 ? '1' : '0';
}