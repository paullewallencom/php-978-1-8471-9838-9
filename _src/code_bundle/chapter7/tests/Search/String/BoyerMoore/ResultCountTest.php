<?php

require_once 'PHPUnit/Framework.php';

require_once('interfaces/StringSearchable.php');
require_once('classes/Search/String/BoyerMoore.php');

// test class are named after the class they test
// and extend PHPUnit_Framework_TestCase
class ResultCountTest extends PHPUnit_Framework_TestCase
{
    // methods are individual test and start with the string "test"
    public function testNumberOfMatches()
    {
        $poem = <<<POEM
Forgetting your coffee spreading on our flannel,
Your lipstick grinning on our coat,
So gaily in love's unbreakable heaven
Our souls on glory of spilt bourbon float.

Be with me, darling, early and late. Smash glasses—
I will study wry music for your sake.
For should your hands drop white and empty
All the toys of the world would break.
POEM;

        // create an instance of the search class
        $bm = new BoyerMoore();

        // execute the search using our algorithm
        $bm->search('our', $poem);

        // assert that the algorithm found the correct
        // number of substrings in the buffer
        $this->assertEquals(7, $bm->getResultsCount(), 'The algorithm did find the correct number of matches.');
    }
}

?>