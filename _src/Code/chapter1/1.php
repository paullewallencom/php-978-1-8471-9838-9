<?php

class SomeClass
{
    // method requires an object of type MyClass
    public function doSomething(MyClass $myClass)
    {
        echo ‘If we made it this far, we know that the name ‘ .
             ‘of the class in the parameter: ‘ . get_class($myClass);
    }

    // method requires an array
    public function passMeAnArray(array $myArray)
    {
        // we don’t need to test is_array($myArr)
        echo "The parameter array contains the following items:\n";
        print_r($myArr);
    }
}

?>