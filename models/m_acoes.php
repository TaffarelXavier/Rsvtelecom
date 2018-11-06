<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../autoload.php';

    $Confg = new Configuracoes($connection);

    $f_family = val_input::sani_string('fontfamily');
    
    $f_size = val_input::sani_string('fontzize');
    
    $config_id = val_input::val_int('config_id');

    echo $Confg->update_configuracoes($f_family,$f_size, $config_id) > 0 ? '1' : '0';
}