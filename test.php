<?php
include 'Calculator.php';

$test = '1  - 4 * 4';
echo $test . " equals: " .Calculator::evaluate($test) . "\n";
$test = '10  + 15 % 4';
echo $test . " equals: " .Calculator::evaluate($test) . "\n";
$test = '2  + 100 / 4';
echo $test . " equals: " .Calculator::evaluate($test) . "\n";
?>
