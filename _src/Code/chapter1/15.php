<?php

// simple numerically indexed array
$myFruits = array('apples', 'bananas', 'cherries');

// use bracket syntax within string to access array
echo "My favorite fruits are {$myFruits[2]}.\n\n";

// longer numerically indexed array
$myLongList = array('The', 'quick', 'brown' ,'fox',
                    'jumped', 'over', 'the', 'lazy',
                    'fox', '.');

// use bracket syntax with variable as index to access array
$listSize = count($myLongList);
for ($i = 0; $i < $listSize; $i++) {
    echo $myLongList[$i];
    echo ($i < $listSize - 2) ? ' ' : '';
}
echo "\n\n";

// associative array; everything lines up
$spanAdj = array('green'  => 'verde',
                 'little' => 'poquito',
                 'big'      => 'grande');

// using a foreach construct to access both keys and values
foreach ($spanAdj as $english => $spanish) {
    echo "'" . $spanish . "' means '" . $english . "' in Spanish.\n";
}

?>