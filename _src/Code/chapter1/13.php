<?php

// inline comment preceding if statement
if (is_array($myHash)) {
    
    // inline comment indented with code
    throw new Exception("myHash must be an array!");
    
// inline comment preceding elseif (preceded by blank line)
} elseif (array_key_exists('index', $myHash)) {
    echo "The key 'index' exists.\n";
        
// inline comment preceding else (preceded by blank line)
} else {
    echo "The key 'index' does NOT exists.\n";    
}

?>