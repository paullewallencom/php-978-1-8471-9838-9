<?php

// unnecessary and confusing
echo ($errorCondition === true)
    ?
        "too bad\n"
    :
        "nice\n";

// keep ';' on the same line as the statement
// don't do this:
echo "goodbye!\n"
;

// must not put multiple statements on a line
echo 'An error has occurred'; exit;

?>