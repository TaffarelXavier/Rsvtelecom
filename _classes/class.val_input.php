<?php

/**
 * <p>Faz validações em campos</p>
 */
class val_input {

    /**
     * 
     * @param type $var Um inteiro
     * @return int
     */
    public static function val_int($var) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return filter_input(INPUT_POST, $var, FILTER_VALIDATE_INT) ? filter_input(INPUT_POST, $var, FILTER_VALIDATE_INT) : false;
        }

        return filter_input(INPUT_GET, $var, FILTER_VALIDATE_INT) ? filter_input(INPUT_GET, $var, FILTER_VALIDATE_INT) : false;
    }

    /**
     * 
     * @param type $var Boolean
     * @return Boolean
     */
    public static function val_boolean($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return filter_input(INPUT_POST, $var, FILTER_VALIDATE_BOOLEAN) ? filter_input(INPUT_POST, $var, FILTER_VALIDATE_BOOLEAN) : false;
        }
        return filter_input(INPUT_GET, $var, FILTER_VALIDATE_BOOLEAN) ? filter_input(INPUT_GET, $var, FILTER_VALIDATE_BOOLEAN) : false;
    }

    /**
     * 
     * @param type $var Valida um número float
     * @return type
     */
    public static function val_float($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return filter_input(INPUT_POST, $var, FILTER_VALIDATE_FLOAT) ? filter_input(INPUT_POST, $var, FILTER_VALIDATE_FLOAT) : false;
        }
        return filter_input(INPUT_GET, $var, FILTER_VALIDATE_FLOAT) ? filter_input(INPUT_GET, $var, FILTER_VALIDATE_FLOAT) : false;
    }

    /**
     * 
     * @param type $var Valida uma url
     * @return url
     */
    public static function val_url($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return filter_input(INPUT_POST, $var, FILTER_VALIDATE_URL) ? filter_input(INPUT_POST, $var, FILTER_VALIDATE_URL) : false;
        }
        return filter_input(INPUT_GET, $var, FILTER_VALIDATE_URL) ? filter_input(INPUT_GET, $var, FILTER_VALIDATE_URL) : false;
    }

    /**
     * 
     * @param type $var valida um email
     * @return email
     */
    public static function val_email($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return filter_input(INPUT_POST, $var, FILTER_VALIDATE_EMAIL) ? filter_input(INPUT_POST, $var, FILTER_VALIDATE_EMAIL) : false;
        }
        return filter_input(INPUT_GET, $var, FILTER_VALIDATE_EMAIL) ? filter_input(INPUT_GET, $var, FILTER_VALIDATE_EMAIL) : false;
    }

    /**
     * 
     * @param type $var Limpa uma string
     * @return string
     */
    public static function sani_string($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num_int = filter_input(INPUT_POST, $var, FILTER_SANITIZE_STRING);
            return isset($num_int) ? $num_int : false;
        }
        $var_get = filter_input(INPUT_GET, $var, FILTER_SANITIZE_STRING);
        return isset($var_get) ? $var_get : false;
    }

    public static function sani_SANITIZE_URL($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num_int = filter_input(INPUT_POST, $var, FILTER_SANITIZE_URL);
            return isset($num_int) ? $num_int : false;
        }
        $var_get = filter_input(INPUT_GET, $var, FILTER_SANITIZE_URL);
        return isset($var_get) ? $var_get : false;
    }

    public static function encoded($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num_int = filter_input(INPUT_POST, $var, FILTER_SANITIZE_URL);
            return isset($num_int) ? $num_int : false;
        }
        $var_get = filter_input(INPUT_GET, $var, FILTER_SANITIZE_URL);
        return isset($var_get) ? $var_get : false;
    }

    public static function special_chars($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num_int = filter_input(INPUT_POST, $var, FILTER_SANITIZE_SPECIAL_CHARS);
            return isset($num_int) ? $num_int : false;
        }
        $var_get = filter_input(INPUT_GET, $var, FILTER_SANITIZE_SPECIAL_CHARS);
        return isset($var_get) ? $var_get : false;
    }

    /**
     * 
     * @param type $var
     * @return type
     */
    public static function _default($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return isset($_POST[$var]) ? $_POST[$var] : false;
        }
        return isset($_GET[$var]) ? $_GET[$var] : false;
    }

    /**
     * 
     * @param type $var Limpa um email
     * @return email
     */
    public static function sani_email($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return filter_input(INPUT_POST, $var, FILTER_SANITIZE_EMAIL);
        }
        return filter_input(INPUT_GET, $var, FILTER_SANITIZE_EMAIL);
    }

    /**
     * 
     * @param type $var Limpa uma url
     * @return url
     */
    public static function sani_url($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num_int = filter_input(INPUT_POST, $var, FILTER_SANITIZE_URL);
            return isset($num_int) ? $num_int : false;
        }
        $var_get = filter_input(INPUT_GET, $var, FILTER_SANITIZE_URL);
        return isset($var_get) ? $var_get : false;
    }

    /**
     * 
     * @param type $var Limpar um número inteiro
     * @return integer
     */
    public static function sani_number_int($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num_int = filter_input(INPUT_POST, $var, FILTER_SANITIZE_NUMBER_INT);
            return isset($num_int) ? $num_int : false;
        }
        $var_get = filter_input(INPUT_GET, $var, FILTER_SANITIZE_NUMBER_INT);
        return isset($var_get) ? $var_get : false;
    }

    /**
     * 
     * @param type $var Limpa um número float
     * @return float
     */
    public static function sani_number_float($var) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num_int = filter_input(INPUT_POST, $var, FILTER_SANITIZE_NUMBER_FLOAT);
            return isset($num_int) ? $num_int : false;
        }
        $var_get = filter_input(INPUT_GET, $var, FILTER_SANITIZE_NUMBER_FLOAT);
        return isset($var_get) ? $var_get : false;
    }

    /**
     * <p>neo_str_array=filter_var_array</p>
     * @param type $varname A variável
     * @param type $tipo O tipo. Por padrão está o tipo:FILTER_SANITIZE_STRING
     * @return boolean
     */
    public static function neo_str_array($varname, $tipo = FILTER_SANITIZE_STRING) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST[$varname])) {
                return (is_array($_POST[$varname]) === true) ? filter_var_array($_POST[$varname], $tipo) : false;
            }
        }
        if (isset($_GET[$varname])) {
            return (is_array($_GET[$varname]) === true) ? filter_var_array($_GET[$varname], $tipo) : false;
        } else {
            return false;
        }
    }

    /**
     * <p>Valida uma data no formato dd//mm/YYYY</p>
     * @param type $string
     */
    public static function validar_data_como_mm_dd_yyyy($string) {
        $re = "/(^(((0[1-9]|[12][0-8])[\\/](0[1-9]|1[012]))|((29|30|31)[\\/](0[13578]|1[02]))|((29|30)[\\/](0[4,6,9]|11)))[\\/](19|[2-9][0-9])\\d\\d$)|(^29[\\/]02[\\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/mi";

        return preg_match($re, $string) ? true : false;
    }

    /**
     * <p>Valida uma data Gregoriana</p>
     * @param type $date
     * @param type $format
     * @return type
     */
    public static function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * <p>Valida uma string com o formato de CPF</p>
     * @param type $cpf A String de entrada. Deve ser do tipo: ###########
     * @return boolean retorna True se o formato é válido, se não é retornado falso
     */
    public static function validaCPF($cpf = null) {

        // Verifica se um número foi informado
        if (empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace('[^0-9]', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    public static function sanitize_html($string) {
        $pattern = array(
            '/(\&lt\;(h1|h2|h3|h4|h5|h6).*?\&gt\;|\&lt\;\/(h1|h2|h3|h4|h5|h6)\&gt\;)/mi',
            '/(\&lt\;(script).*?\&gt\;|\&lt\;\/(script)\&gt\;)/mi',
            '/\<(h1|h2|h3|h4|h5|h6).*?\>|<\/(.?h1.?|.?h2.?|.?h3.?|.?h4.?|.?h5.?|.?h6.?)\>/mi',
            '/\<(p).*?\>|<\/(.?p.?)\>/mi',
            '/\<(script).*?\>|<\/(.?script.?)\>/mi',
            '/\<(b).*?\>|<\/(.?b.?)\>|\<b\>/mi'
        );
        
        $replacement = array('', '', '', '', '','','');

        return (preg_replace($pattern, $replacement, $string));
    }

    /**
     * 
     * @param type $text
     * @return bool
     */
    public static function isUrl($text) {
        return filter_var($text, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) !== false;
    }

}
