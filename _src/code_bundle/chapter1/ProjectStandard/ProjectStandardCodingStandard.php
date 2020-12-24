<?php

// make sure the parent class is in our include path
//if (class_exists('PHP_CodeSniffer_Standards_CodingStandard', true) === false) {
//    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_CodingStandard not found');
//}

// our main coding standard class definition
class PHP_CodeSniffer_Standards_ProjectStandard_ProjectStandardCodingStandard extends PHP_CodeSniffer_Standards_CodingStandard
{
    // include sniffs from other directories or even whole coding standards
    // great way to create your standard and build on it
    public function getIncludedSniffs()
    {
        // return an arry of sniffs, dirctories of sniffs,
        // or coding standards to include
        return array(
                    'Generic'
                    );
    }

    // exclude sniffs from previously included ones
    public function getExcludedSniffs()
    {
        // return a list of sniffs or dirctories of sniffs to exclude
        return array(
                    'Generic/Sniffs/LineLengthSniff.php'
                    );
    }
}

?>