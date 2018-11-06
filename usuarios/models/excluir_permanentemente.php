<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Usuarios = new Usuarios($connection);

    $usuario_id = val_input::sani_string('usuario_id');

    echo $Usuarios->excluir_usuario_permanentemente($usuario_id) > 0 ? '1' : '0';
}