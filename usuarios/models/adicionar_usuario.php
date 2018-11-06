<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Usuarios = new Usuarios($connection);

    $nome = trim(val_input::sani_string('nome'));

    $cpf = val_input::sani_string('senha');

    $nivel = val_input::sani_string('nivel');
    
    if ($Usuarios->conta_existe($nome) > 0) {
        exit("CONTA_EXISTE");
    } else if ($nome == "" || empty($nome) || $nome == false) {
        exit("USUAIO_INCORRETO");
    } else {
        echo $Usuarios->adicionar_usuario($nome, $cpf, $nivel) > 0 ? '1' : '0';
    }
}