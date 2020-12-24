<?php

abstract class Probe
{
    protected $maxProbes = null;
    protected $probeCount = array();
    
    public function __construct($maxProbes = 3)
    {
        $this->maxProbes = $maxProbes;
    }
    
    // method to keep track of connections count by host & port
    protected function increaseProbeCount($host, $port)
    {
        // check whether an entry already exists
        if (array_key_exists($host, $this->probeCount)
            && array_key_exists($port, $this->probeCount[$host])) {
                
                $this->probeCount[$host][$port]++;

            // create new entry
            } else {
                $this->probeCount[$host][$port] = 1;
            }
    }
    
    // have we reached the maximum number of allowed probes?
    public function maxProbesExceeded($host, $port)
    {
         return (isset($this->probeCount[$host][$port])) ? $this->probeCount[$host][$port] > $this->maxProbes : false;
    }
}

?>