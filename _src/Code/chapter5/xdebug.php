<?php

// configure Xdebug locally
ini_set('xdebug.var_display_max_children', 3);
ini_set('xdebug.var_display_max_data', 6);
ini_set('xdebug.var_display_max_depth', 2);

class DebugExample
{
    private $imHiding = FALSE;
    public  $slf = null;
    
    public function __construct()
    {
        $this->slf = $this;
    }
    
    public function trySomething()
    {
        $this->somethingWrong('dead');
    }
    
    public function somethingWrong($bang)
    {
        $ie = array('just'  => 'something',
                    'to'    => 'output',
                    'for'   => 'the',
                    'Debug' => 'Exception');


        var_dump($this);
        var_dump($ie);
//        throw new Exception("exceptions are no good!");
    }
}

$debugExample = new DebugExample();

$debugExample->trySomething();

?>