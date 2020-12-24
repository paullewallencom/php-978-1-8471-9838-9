<?php

require_once('interfaces/StringSearchable.php');

class BoyerMoore implements StringSearchable
{
    // class constants
    const CASE_SENSITIVE = true;
    const CASE_INSENSITIVE = false;
    
    // the substring for which to search
    public $substring = 'null';
    public $originalSubstring = 'null';
    
    // the buffer to be searched for any occurrences of the substring
    public $buffer = '';
    public $originalBuffer = '';
    
    // jump table derived from substring
    public $jumpTable = array();
    
    // array of results
    protected $results = array();

    public function __construct()
    {
        // intentionally left blank
    }

    public function __destruct()
    {
        // intentionally left blank
    }

    public function search($substring, $buffer, $caseSensitive = self::CASE_SENSITIVE)
    {
        // validate input
        if (!is_string($substring) || strlen($substring) < 1) {
            throw new Exception("Substring to search for must be a string with one or more characters.");
        } elseif (!is_string($buffer) || strlen($buffer) < 1) {
            throw new Exception("Buffer through which to search must be a string with one or more characters.");
        } elseif (!is_bool($caseSensitive)) {
            throw new Exception("The third argument to function " . __FUNCTION__ . " must be a boolean.");
        }    

        // reset results array
        $this->results = array();

        $this->substring = $substring;
        $this->originalSubstring = $substring;
        $this->buffer = $buffer;
        $this->originalBuffer = $buffer;
        
        // change the working buffer & substring to lower cass
        // if the search is to be case-insensitive
        if ($caseSensitive != self::CASE_SENSITIVE) {
            $this->substring = strtolower($this->substring);
            $this->buffer = strtolower($this->buffer);
        }
        
        // get jump table
        $this->deriveJumpTable();

        $currentCharacter = strlen($this->substring) - 1;
        $substringLength = strlen($this->substring);
        $bufferLength = strlen($this->buffer);

        while ($currentCharacter < $bufferLength) {

            for ($i = $substringLength - 1; $i >= 0; $i--) {

                // character matches, continue ...
                if ($this->buffer{($currentCharacter - $substringLength + $i + 1)} == $this->substring{$i}) {

                    // did all letters match?
                    if ($i == 0) {
                        $this->results[] = $currentCharacter - $substringLength;
                        $currentCharacter += $this->getJumpLength($this->buffer{$currentCharacter});

                    } else {
                        continue;
                    }

                // mismatch, jump ahead ...
                } else {
                    $currentCharacter += $this->getJumpLength($this->buffer{$currentCharacter});
                    break;
                }
            }
        }
        
        // return true if any matches occurred, false otherwise
        return (sizeof($this->results) > 0);
    }
    
    // create lookup table that determines how far we can
    // jump ahead if a character doesn't match
    protected function deriveJumpTable()
    {
        $maxJump = strlen($this->substring);

        // loop over letters of 
        for ($i = strlen($this->substring) - 2; $i >= 0; $i--) {
            if (!array_key_exists($this->substring{$i}, $this->jumpTable)) {
                $this->jumpTable[$this->substring{$i}] = $maxJump - $i - 1;
            }
        }
    }
    
    // return the jump table
    public function getJumpTable()
    {
        return $this->jumpTable;
    }
    
    // return the results array
    public function getResults()
    {
        return $this->results;
    }
    
    // how many matches did we find?
    public function getResultsCount()
    {
        return sizeof($this->results);
    }
    
    // use the jump table to determine how far
    // to move ahead in the buffer
    public function getJumpLength($character)
    {
        if (array_key_exists($character, $this->jumpTable)) {
            return $this->jumpTable[$character];
        } else {
            return strlen($this->substring);
        }
    }
}

?>