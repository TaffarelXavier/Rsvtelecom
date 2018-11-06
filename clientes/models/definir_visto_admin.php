<?php

/**
 * 
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    if (isset($_POST['boletos'])) {

        $Clientes = new Clientes($connection);

        $arr = $_POST['boletos'];
        
        $n = array();

        foreach ($arr as $key => $value) {
            if ($value != "") {
                $n[$key] = $value;
            }
        }
 
        $sql = 'UPDATE `boletos` SET `boleto_visto_admin` = \'sim\' WHERE `boletos`.`boleto_id` IN';

        $sql .= '(' . implode($n, ',') . ');';
        
        echo $Clientes->marcar_como_visto($sql) > 0 ? 1 : 0;
    }
}