<?php

$lines = file('/Users/dirk/Documents/Work/WaferThin/Packt/Book/Code/chapter6/classes/PhpIni.php');
$selectedLines = array_slice($lines, 10, 20);
echo highlight_string(implode('', $selectedLines));

?>