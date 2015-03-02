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

    public function evaluate($input) {

    }

    private static function validateInput($input) {

    }

    private static function parseInput($input) {

    }

    private static function convertToPostFix($input) {

    }

    private static function evaluatePostFix($input) {

    }
}

?>
