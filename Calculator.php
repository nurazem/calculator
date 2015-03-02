<?php
class Calculator {
    private static $input;
    private static $operators = array(
        '+' => 'add',
        '-' => 'subtract',
        '*' => 'multiply',
        '/' => 'divide',
        '%' => 'modulo'
    );
    private static $precedences = array(
        '+' => 1,
        '-' => 1,
        '*' => 2,
        '/' => 2,
        '%' => 2,
    );

    public function getInput() {
        return self::$input;
    }

    public function setInput($input) {
        self::$input = (string)$input;
        return true;
    }

    public function evaluate($input) {

    }

    private static function validateInput($input) {

    }

    private static function parseInput($input) {
        $regex = '/'.preg_quote($operators, '/').'/';
        $input = preg_replace($regex, " $0 ", $input);
        $input = trim(preg_replace('/\s+/', ' ', $input));
        return $input;
    }

    private static function convertToPostFix($input) {

    }

    private static function evaluatePostFix($input) {

    }
}

?>
