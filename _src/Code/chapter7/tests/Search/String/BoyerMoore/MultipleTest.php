<?php

require_once 'PHPUnit/Framework.php';

require_once('interfaces/StringSearchable.php');
require_once('classes/Search/String/BoyerMoore.php');

class MultipleTest extends PHPUnit_Framework_TestCase
{
    protected $bm;
    
    protected function setUp()
    {
        // create the new search class
        $this->bm = new BoyerMoore();
    }
        
    /**
     * @dataProvider provider
     */
    public function testNumberOfMatches($buffer, $substring, $matches)
    {
        // execute the search
        $this->bm->search($substring, $buffer);

        // assert that the algorithm found the correct
        // number of substrings in the buffer
        $this->assertEquals($matches, $this->bm->getResultsCount());
    }

    // This method provides data to be used when calling
    // method testNumberOfMatches()
    public function provider()
    {
        return array(
                    array('abcdeabcdabcaba', 'abc', 3),
                    array(<<<POEM
Forgetting your coffee spreading on our flannel,
Your lipstick grinning on our coat,
So gaily in love's unbreakable heaven
Our souls on glory of spilt bourbon float.

Be with me, darling, early and late. Smash glasses—
I will study wry music for your sake.
For should your hands drop white and empty
All the toys of the world would break.
POEM
                            , 'our', 7)
                    );
    }

    // testing case-insensitive search
    public function testCaseInsensitive()
    {
        // get data array from provider method
        $dataArr = $this->provider();
    
        // execute the search
        $this->bm->search('our', $dataArr[1][0], BoyerMoore::CASE_INSENSITIVE);

        // assert that the algorithm found the correct
        // number of substrings in the buffer
        $this->assertEquals(8, $this->bm->getResultsCount());
    }
}

?>