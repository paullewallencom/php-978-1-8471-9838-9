<?php

class MyClass
{
    private myAttrib;

    // short constructor - no parameters this time
    public function __construct()
    {
        // intentionally left blank
    }

    // initialization method to be called
    // immediately after object instantiation
    public function init($var)
    {
        $this->myAttrib = trim$(var);
    }
}

// first we instantiate the object
$myObject = new MyClass();

// then we initialize the object
$myObject->init('a string literal');

?>