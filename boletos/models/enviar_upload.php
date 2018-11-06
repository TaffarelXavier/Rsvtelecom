<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Upload = new Upload();

    $Boletos = new Boletos($connection);

    $Upload->cemvs_max_size_file = 1073741824;

    $Upload->cemvs_min_size_file = 1;

    $Upload->tipos_permitidos = array("application/pdf", "application/force-download");

    $upload = $Upload->iniciar('file', '../../arquivos-de-boletos/');
    
    $cliente_id = val_input::val_int('cliente_id');
    
    if ($upload == true) {

        echo $Boletos->inserir($Upload->file_in_md5, $Upload->real_file_name, $cliente_id) > 0 ? '1' : '0';

    } else {
        ?>
            <?php
            print_r($upload);
            ?>
        <?php
    }
}

