<?php

//if (class_exists('Generic_Sniffs_Files_LineLengthSniff', true) === false) {
//    throw new PHP_CodeSniffer_Exception('Class Generic_Sniffs_Files_LineLengthSniff not found');
//}

// class to check line length in number of characters
// note: we're overwriting an existing sniff from the generic coding standard
class Zend_Sniffs_Files_LineLengthSniff extends Generic_Sniffs_Files_LineLengthSniff
{
    // we generate an error when exceeding the absolute
    // maximum line length
    protected $absoluteLineLimit = 120;
}

?>
