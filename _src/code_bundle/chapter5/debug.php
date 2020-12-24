<?php

require_once('classes/DebugException.php');

class DebugExample
{
    private $imHiding = FALSE;
    
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

        throw new DebugException("exceptions are no good!");
    }
}

$debugExample = new DebugExample();

$debugExample->trySomething();

?>