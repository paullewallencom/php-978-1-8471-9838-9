<?php

// get the contents of this file into a variable
$thisFile = file_get_contents(__FILE__);

// get the token stack
$tokenStack = token_get_all($thisFile);

$currentLine = 0;

// output each token & look up the corresponding name
foreach ($tokenStack as $token) {

    // most tokens are arrays
    if (is_array($token)) {

        if ($currentLine < $token[2]) {
            $currentLine++;
            echo "Line $currentLine:\n";
        }
        echo "\t" . token_name($token[0]) . ': ' . rtrim($token[1]) . "\n";

    // some tokens are just strings
    } else {
        echo "\tString: " . rtrim($token) . "\n";
    }
}

?>