<?php

// sniff class definition must implement the
// PHP_CodeSniffer_Sniff interface
class ProjectStandard_Sniffs_Syntax_FullPhpTagsSniff implements PHP_CodeSniffer_Sniff
{
    // register for the tokens we're interested in
    public function register()
    {
        return array(T_OPEN_TAG);
    }

    // process each occurrence of the token in this method
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // warn if the opening PHP tag is not the first token in the file
        if ($stackPtr != 0) {
            $phpcsFile->addWarning('Nothing should precede the PHP open tag.', $stackPtr);
        }
        
        // error if full PHP open tag is not used
        if ($tokens[$stackPtr]['content'] != '<?php') {
            $phpcsFile->addError('Only full PHP opening tags are allowed.', $stackPtr);
        }
        
        // all files must have closing tag
        if ($token[sizeof($tokens) - 1]['type'] != T_CLOSE_TAG) {
            $phpcsFile->addError('All files must end with a closing PHP tag.', $stackPtr);
        }
    }
}

?>