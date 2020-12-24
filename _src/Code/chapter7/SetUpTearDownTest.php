<?php

require_once 'PHPUnit/Framework.php';

class SetUpTearDownTest extends PHPUnit_Framework_TestCase
{
	// illustrating call to setUp method
	protected function setUp()
	{
		echo "executing " . __FUNCTION__ . "\n";
	}
		
	// first generic test method
	public function test1()
    {
		echo "executing " . __FUNCTION__ . " \n";
    }

	// second generic test method
	public function test2()
    {
		echo "executing " . __FUNCTION__ . " \n";
    }

	// illustrating call to tearDown method
	protected function tearDown()
	{
		echo "executing " . __FUNCTION__ . " \n";
	}
}

?>