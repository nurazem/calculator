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
        '%' => 2
    );

    public function evaluate($input) {
        self::$input = (string)$input;
        self::validateInput();
        $expression = self::parseInput(self::$input);
        $postfix = self::convertToPostFix($expression);
        return self::evaluatePostFix($postfix);
    }

    public function getInput() {
        return self::$input;
    }

    public function setInput($input) {
        self::$input = (string)$input;
        return true;
    }

    private static function validateInput() {
        if (!self::$input) {
            throw new Exception('Input is empty');
        }

        $expression = explode(' ', self::$input);
        if (!is_numeric($expression[0]) || !is_numeric(end($expression))) {
            throw new Exception('First and last elements of expression have to be numeric');
        }

        foreach ($expression as $element) {
            if(!is_numeric($element) || !array_key_exists($element, self::$operators)) {
                throw new Exception('Invalid expression');
            }
        }

    }

    private static function parseInput($input) {
        $operators = implode('', array_keys(self::$operators));
        $regex = '/'. preg_quote($operators, '/') .'/';
        $input = preg_replace($regex, " $0 ", $input);
        $input = trim(preg_replace('/\s+/', ' ', $input));
        return $input;
    }

    private static function convertToPostFix($input) {
        $op_stack = array();
        $postfix_list = array();
        $tokens = explode(' ', $input);

        foreach($tokens as $token) {
            if(!array_key_exists($token, self::$operators)) {
                array_push($postfix_list, $token);
            } else {
                while(!empty($op_stack) && self::$precedences[end($op_stack)] >= self::$precedences[$token]) {
                    $top_op = array_pop($op_stack);
                    array_push($postfix_list, $top_op);
                }
                array_push($op_stack, $token);
            }
        }

        while(!empty($op_stack)) {
            $top_op = array_pop($op_stack);
            array_push($postfix_list, $top_op);
        }
        return $postfix_list;
    }

    private static function evaluatePostFix($expression) {
        $stack = array();
        foreach($expression as $element) {
            if(array_key_exists($element, self::$operators)) {
                $second = array_pop($stack);
                $first = array_pop($stack);
                $value = call_user_func(array(self, self::$operators[$element]), $first, $second);
                array_push($stack, $value);
            } else {
                array_push($stack, intval($element));
            }
        }

        return array_pop($stack);
    }

    private static function add($a, $b) {
        return $a + $b;
    }

    private static function subtract($a, $b) {
        return $a - $b;
    }

    private static function divide($a, $b) {
        return $a / $b;
    }

    private static function multiply($a, $b) {
        return $a * $b;
    }

    private static function modulo($a, $b) {
        return $a % $b;
    }
}

?>
