<?php
class AlwaysUseGetters
{
	// private property not accessible outside this class
    private $myValue;

	// setter method
    public function setMyValue($myValue)
    {
        $this->myValue = $myValue;
    }

	// getter method
    public function getMyValue()
    {
        return $this->myValue;
    }

    public function doSomething($text)
    {
		// use getter to retrieve property
        return $text . $this->getMyValue() . '!';
    }
}

// instantiate object
$myAwc = new AlwaysUseGetters();

// use setter to set property
$myAwc->setMyValue('book');

// call method to illustrate use of getter
echo $myAwc->doSomething('This is an awesome ');
?>