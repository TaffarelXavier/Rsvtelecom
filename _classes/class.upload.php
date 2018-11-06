<?php

/**
 * @author NeoInovat
 * <p>Classe responsável pelos uploads do sistema</p>
 */
class Upload {

    public function __construct() {
        
    }

    /**
     * <p>Essa variável pega o caminho completo do arquivo</p>
     * @var type 
     */
    public $get_type = null;

    /**
     * <p>Essa variável pega o caminho completo do arquivo</p>
     * @var type 
     */
    public $full_file = null;

    /**
     * <p>Essa variável pega somente o nome do arquivo com sua extensão no formato md5</p>
     * @var type 
     */
    public $file_in_md5 = null;

    /**
     * <p>Essa variável pega somente o nome do arquivo com sua extensão no formato md5</p>
     * @var type 
     */
    public $real_file_name = null;

    /**
     * <p>Essa constante define o tamanho máximo do arquivo, por padrão 5 megabytes</p> 
     */
    public $cemvs_max_size_file = 5242880;

    /**
     * <p>V CEMVS_MAX_SIZE_FILE</p>
     * <p>Essa constante define o tamanho MÍNIMO do arquivo, por padrão 5 megabytes</p> 
     */
    public $cemvs_min_size_file = 1; //1 byte

    /**
     * O nome temporário do arquivo, como foi guardado no servidor. 
     * @var type 
     */
    public $path_tmp_name = '';

    /**
     * <p>Os tipos de arquivos permitidos.</p>
     * @var Array
     */
    public $tipos_permitidos = array(
        "application/pdf",
        "application/msword",
        "application/vnd.ms-word.document.macroEnabled.12",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "audio/mp3",
        "video/x-ms-wmv"
    );
    private $mensagem = array(
        'Não houve erro',
        'O arquivo no upload é maior do que o limite do PHP',
        'O arquivo ultrapassa o limite de tamanho especifiado no HTML',
        'O upload do arquivo foi feito parcialmente',
        'Não foi feito o upload do arquivo'
    );
    public $get_path_name = "";

    /**
     *
     * @var type 
     */
    public $error = '';

    /**
     * A extensão do arquivo
     * @var type 
     */
    public $ext = '';

    /**
     * <p>Pega apenas o nome do arquivo com sua extensão em formato de md5</p>
     * @return string
     */
    public function get_file_name() {
        return (string) $this->file_in_md5;
    }

    /**
     * <p>Pega apenas o nome do arquivo com sua extensão real</p>
     * @return string
     */
    public function get_real_file_name() {
        return (string) $this->real_file_name;
    }

    /**
     * <p>Pega todo o nome do arquivo, incluindo o nome da pasta e raiz. Fullname</p>
     * @return string
     */
    public function get_full_file_name() {
        return (string) $this->full_file;
    }

    /**
     * 
     * @return type
     */
    public function get_ext() {
        return $this->ext;
    }

    /**
     * <p>O nome da variável</p>
     * @param type $var_nome O nome da variável que vem do inpout html
     * @param type $path O da pasta onde será gravado os arquivos
     * @example path <input file='$var_nome' />
     */
    public function iniciar($var_nome = "file", $path = "../arquivos/", $novo_nome = false) {

        if (!isset($_FILES[$var_nome])) { //Se não existir a variável
            $this->error = '0';
            exit("Não foi possível fazer o upload do arquivo.");
        }
        $pathinfo = pathinfo($_FILES[$var_nome]['name']); //Pega algumas informações sobre o arquivo

        $file_md5 = md5(uniqid(rand(), true)); /* Rápido, apenas para nome de arquivos */

        $this->get_type = $_FILES[$var_nome]['type'];

        $this->tratamento_de_erros($var_nome); /* Função pública para tratamentos de erros */

        $this->real_file_name = $_FILES[$var_nome]['name']; /* Pega o real nome do arquivo */

        if ($novo_nome == false) {
            $this->full_file = $path . $file_md5 . "." . $pathinfo["extension"]; /* Gera um novo nome para poder gravar no banco. */
        } else {
            $this->full_file = $path . $novo_nome . '.' . $pathinfo["extension"];
        }

        $this->get_path_name = $path;

        $this->ext = pathinfo($_FILES[$var_nome]['name'], PATHINFO_EXTENSION);

        if (is_uploaded_file($_FILES[$var_nome]['tmp_name'])) {
            if (move_uploaded_file($_FILES[$var_nome]['tmp_name'], $this->full_file)) {
                
                if ($novo_nome == false) {
                    $this->file_in_md5 = $file_md5 . "." . $pathinfo["extension"];
                } else {
                    $this->file_in_md5 = $novo_nome . "." . $pathinfo["extension"];
                }

                $this->error = "success";
                return true;
            } else {
                $this->error = '0';
                return $this->mensagem[$_FILES[$var_nome]['error']];
            }
        }
    }

    /**
     * <p>O nome da variável</p>
     * @param type $var_nome O nome da variável que vem do inpout html
     * @param type $path O da pasta onde será gravado os arquivos
     * @example path <input file='$var_nome' />
     */
    public function set_upload_tmp($var_nome = "file", $path = "../arquivos/") {

        if (!isset($_FILES[$var_nome])) { //Se não existir a variável
            $this->error = '0';
            exit("Não foi possível fazer o upload do arquivo.");
        }
        $pathinfo = pathinfo($_FILES[$var_nome]['name']); //Pega algumas informações sobre o arquivo

        $file_md5 = md5(uniqid(rand(), true)); //Rápido, apenas para nome de arquivos

        $this->get_type = $_FILES[$var_nome]['type'];

        $this->tratamento_de_erros($var_nome); //Função pública para tratamentos de erros

        $this->real_file_name = $_FILES[$var_nome]['name']; //Pega o real nome do arquivo

        $this->full_file = $path . $file_md5 . "." . $pathinfo["extension"]; //Gera um novo nome para poder gravar no banco.

        $this->get_path_name = $path;

        $this->path_tmp_name = $_FILES[$var_nome]['tmp_name'];

        $this->ext = pathinfo($_FILES[$var_nome]['name'], PATHINFO_EXTENSION);

        return $this->file_in_md5 = $file_md5 . "." . $pathinfo["extension"];
    }

    /**
     * <p>O nome da variável</p>
     * @param type $var_nome O nome da variável que vem do inpout html
     * @example path <input file='$var_nome' />
     */
    public function tratamento_de_erros($var_nome) {
        if (!in_array($_FILES[$var_nome]['type'], $this->tipos_permitidos)) {
            $this->error = '0';
            exit("Não é permitido o tipo de arquivo: [" . $_FILES[$var_nome]['type'] . '].');
        } else if ($_FILES[$var_nome]['size'] > $this->cemvs_max_size_file) { //5 megabystes por padrão.
            $this->error = '0';
            exit("O arquivo é maior que o permitido " . $this->cemvs_max_size_file);
        } else if ($_FILES[$var_nome]['size'] < $this->cemvs_min_size_file) {// Faz a verificação do tamanho do arquivo se for menor que 20 kbytes
            $this->error = '0';
            exit("O arquivo enviado é muito pequeno, envie arquivos de maior que 62 kbytes.");
        } else if (!is_readable($_FILES[$var_nome]['tmp_name'])) {
            $this->error = '0';
            exit("O arquivo não pôde ser lido.");
        } else if ($_FILES[$var_nome]['error'] == 1) {
            $this->error = '0';
            exit($this->mensagem[1]);
        } else if ($_FILES[$var_nome]['error'] == 2) {
            $this->error = '0';
            exit($this->mensagem[2]);
        } else if ($_FILES[$var_nome]['error'] == 3) {
            $this->error = '0';
            exit($this->mensagem[3]);
        } else if ($_FILES[$var_nome]['error'] == 4) {
            $this->error = '0';
            exit($this->mensagem[4]);
        }
    }

}
