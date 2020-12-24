<?php

// defining a simple string
$myOutput = 'This is an awesome book!';

$adjectives = array('nicer',
                    'better',
                    'cleaner');

// string with variable interpolation and formatting characters
echo "Reading this book makes a good PHP programer $adjectives[1].\n";

// double quotes containing single quote
echo "This book's content will make you a better developer!";

// defining long strings by breaking them up
$chapterDesc = 'In this chapter, we are trying to explore how'
             . 'a thorough and clear common coding standard'
             . ' benefits the project as well as each individual'
             . 'developer.';

// I'm not much of a poet, but this is how you use the heredoc syntax
$poem = <<<ENDOFSTRING
Roses are red,
violets are blue,
this is my poem
for the code in you.
ENDOFSTRING;

?>