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

    public function getInput() {
        return self::$input;
    }

    public function setInput($input) {
        self::$input = (string)$input;
        return true;
    }

    public function evaluate($input) {
        self::$input = (string)$input;
        $expression = self::parseInput(self::$input);
        self::validateInput($expression);
        $postfix = self::convertToPostFix($expression);
        return self::evaluatePostFix($postfix);
    }

    private static function validateInput($input) {
        if (!$input) {
            throw new Exception('Input is empty');
        }

        // $expression = explode(' ', $input);
        // if (!is_numeric($expression[0]) || !is_numeric(end($expression))) {
        //     throw new Exception('First and last elements of expression have to be numeric');
        // }

        // foreach ($expression as $element) {
        //     if(!is_numeric($element) || !array_key_exists($element, self::$operators)) {
        //         throw new Exception('Invalid expression');
        //     }
        // }
    }

    /*
    * Parse input string to add spaces between numbers and operators
    * and remove any unnecessary spaces
    */
    private static function parseInput($input) {
        $operators = implode('', array_keys(self::$operators));
        $regex = '/'. preg_quote($operators, '/') .'/';
        $input = preg_replace($regex, " $0 ", $input);
        $input = trim(preg_replace('/\s+/', ' ', $input));
        return $input;
    }

    /*
    * Convert infix to postfix expresssion for trivial computation by using a stack
    */
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

    /*
    * Evaluate postfix expresssion by using a stack
    */
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

    /*
    * Math functions corresponding to values of the $operators
    */
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
