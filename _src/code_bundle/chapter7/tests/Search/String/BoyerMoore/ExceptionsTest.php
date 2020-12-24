<?php

require_once 'PHPUnit/Framework.php';

require_once('interfaces/StringSearchable.php');
require_once('classes/Search/String/BoyerMoore.php');

// test class are named after the class they test
// and extend PHPUnit_Framework_TestCase
class ExceptionsTest extends PHPUnit_Framework_TestCase
{
    protected $bm;
    
    protected function setUp()
    {
        // create the new search class
        $this->bm = new BoyerMoore();
    }

    /** 
     * Testing that an exception being thrown if the buffer,
     * substring, or 3rd argument don't pass validation.
     *
     * @dataProvider provider
     * @expectedException Exception 
     */
    public function testExceptions($buffer, $substring, $caseSensitive)
    {
        // execute the search using our algorithm
        $this->bm->search($substring, $buffer, $caseSensitive);
    }

    // This method provides data to be used when calling
    // method testNumberOfMatches()
    public function provider()
    {
        return array(
                    array('', 'find me', BoyerMoore::CASE_SENSITIVE), // empty buffer
                    array(null, 'find me', BoyerMoore::CASE_SENSITIVE), // null buffer
                    array(array(), 'find me', BoyerMoore::CASE_SENSITIVE), // array buffer
                    array('search me', '', BoyerMoore::CASE_SENSITIVE), // empty substring
                    array('search me', null, BoyerMoore::CASE_SENSITIVE), // null substring
                    array('search me', array(), BoyerMoore::CASE_SENSITIVE), // array substring
                    array('search me', 'find me', 'whatever'), // wrong 3rd arg
                    );
    }
}

?>