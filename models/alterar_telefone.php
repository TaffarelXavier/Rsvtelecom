<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../autoload.php';

    $Confg = new Configuracoes($connection);

    $telefone = val_input::sani_string('config_fone');
    
    $config_id = val_input::sani_string('config_id');

    echo $Confg->atualiazar($telefone, $config_id) > 0 ? '1' : '0';
}