<?php

// all conditionals on the same line
if ($myValue <= -1 || $myValue > 100) {
    doSomethingImportant();
}

// too many conditional for one line
// break up condiationals like this ...
if ($myValue > 5
    || $myValue < 5
    || $myValue == 0
    || $myValue == -3) {

    doSomethingElseImportant();
}

?>