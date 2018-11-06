<?php

class Sanitize_Output {

    public function __construct() {

        //Minifica o código html
        function sanitize_output($buffer) {

            $search = array(
                '/\>[^\S ]+/s', // strip whitespaces after tags, except space
                '/[^\S ]+\</s', // strip whitespaces before tags, except space
                '/(\s)+/s'       // shorten multiple whitespace sequences
            );

            $replace = array(
                '>',
                '<',
                '\\1'
            );

            $buffer = preg_replace($search, $replace, $buffer);

            return $buffer;
        }

        ob_start("sanitize_output");
    }

}
