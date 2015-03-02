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

    public function getInput() {
        return self::$input;
    }

    public function setInput($input) {
        self::$input = (string)$input;
        return true;
    }

    private static function validateInput($input) {

    }

    private static function parseInput($input) {
        $regex = '/'.preg_quote(self::$operators, '/').'/';
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

    private static function evaluatePostFix($input) {

    }
}

?>
