<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../autoload.php';

    $Usuarios = new Usuarios($connection);

    $nome = val_input::sani_string('uname');

    $senha = val_input::sani_string('psw');

    if ($Usuarios->login($nome, $senha) === true) {
        echo '1';
    } else {
        echo '0';
    }
}