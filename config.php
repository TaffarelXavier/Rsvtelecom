<?php

//========================================================================================
//                              CONFIGURAÇÃO DO SISTEMA
//========================================================================================
/* Se for https */
if (isset($_SERVER['HTTPS'])) {

    define('_DOMINIO_', '//' . $_SERVER['SERVER_NAME'] . '/' . 'admin' . '/');
} else {

    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        define('_DOMINIO_', '//' . $_SERVER['SERVER_NAME'] . '/' . 'admin' . '/');
    } else {
        define('_DOMINIO_', '//' . $_SERVER['SERVER_NAME'] . '/' . 'admin' . '/');
    }
}
//Define a base do sistema
define('SYS_BASE_NAME', _DOMINIO_);

//Define a raiz do sistema
define('SYS_DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);

define('SERVER_NOME', $_SERVER['SERVER_NAME']);

define('SERVIDOR_CEMVS', 'cemvs.ltai.com.br');

//Define o caminho da fonte a ser usada
define('FONTE_NAME', '../_helpers/century_gothic.gdf');

//Define o tamanho da String a ser usada
define('TAMANHO', 3);

define('BACKUP_NAME', 'admin');

define('BACKUP_PASTA', SYS_DOC_ROOT . 'admin' . '/' . 'backup' . '/');

define('SYS_LOGO', 'logo.png');

switch (SERVER_NOME) {
    case 'valdoboletos.com':
        /** MySQL hostname */
        define('DB_HOST', 'localhost');
        /** MySQL database username */
        define('DB_USER', 'root');
        /** The name of the database for WordPress */
        define('DB_NAME', 'boletos_db');
        /** MySQL database password */
        define('DB_PASSWORD', 'chkdsk');
        break;
    case 'rsvtelecom.ltai.com.br':
    case 'rsvtelecom.com.br':
    case 'www.rsvtelecom.com.br':
    case 'rsvtelecom-com-br.umbler.net':
    case 'www.rsvtelecom-com-br.umbler.net':
        /** MySQL hostname */
        define('DB_HOST', 'mysql427.umbler.com');
        /** MySQL database username */
        define('DB_USER', 'boleto_user');
        /** The name of the database for WordPress */
        define('DB_NAME', 'boleto_db');
        /** MySQL database password */
        define('DB_PASSWORD', '_[y+4pU*w7Z');
        break;
    case 'rsvtelecom.localhost.com.br':
        /** MySQL hostname */
        define('DB_HOST', 'localhost');
        /** MySQL database username */
        define('DB_USER', 'root');
        /** The name of the database for WordPress */
        define('DB_NAME', 'boleto_db');
        /** MySQL database password */
        define('DB_PASSWORD', 'chkdsk');
        break;
}


if (isset($_SESSION['_sessao'])) {
    define('_LOGADO_', true);
}

//===================================
//         Verificando acesso
//===================================
//O Ip do usuário
$meuip = $_SERVER['REMOTE_ADDR'];

//Verificando o IP
try {
    $connection = new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (Exception $exc) {
    echo $exc->getMessage();
}

if (isset($_SESSION['logado'])) {
    $Usuarios = new Usuarios($connection);
    $Dados = $Usuarios->get_usuario_por_id($_SESSION['tx_dados_usuario']['conta_id']);
    $_SESSION['tx_dados_usuario'] = $Dados;

    if ($_SESSION['tx_dados_usuario'] === false) {
        header('location: _sistema/funcoes-global/sair.php');
        exit();
    }
}
