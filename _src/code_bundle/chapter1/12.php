<?php

if (is_array($myHash)) {
    throw new Exception("myHash must be an array!");
} elseif (array_key_exists('index', $myHash)) {
    echo "The key 'index' exists.\n";
} else {
    echo "The key 'index' does NOT exists.\n";    
}

?>