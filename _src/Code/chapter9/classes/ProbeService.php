<?php

class ProbeService extends Probe implements Interrogator
{
    // map of port numbers to common service names
    public static $serviceName = array(23    => 'telnet',
                                        25    => 'smtp',
                                        80    => 'http',
                                        110 => 'pop3',
                                        443    => 'https'
                                        );
    
    // constructor initializes maxProbes to 3
    public function __construct($maxProbes = 3)
    {
        parent::__construct($maxProbes);
    }
    
    // probe host and port
    public function probe($ip, $port)
    {        
        try {
                
            // check max probing limit
            if (!$this->maxProbesExceeded($ip, $port)) {

                // increment the number of times this ip & port were probed
                $this->increaseProbeCount($ip, $port);

                // instantiate a connection object
                $connection = new Connection($ip, $port);

                // got a responsive port
                if ($connection->connect()) {

                    // return successful connection object
                    return $connection;
                    
                // unable to establish a connection
                } else {
                    return FALSE;
                }
                
            // throw max number of probes exceeded exception
            } else {
                throw new Exception("Maximum probe limit of $this->maxProbes exceeded for IP address $ip on port $port.");
            }

        // catch exceptions and notify user
        } catch (Exception $e) {
            echo ("Unable to probe $ip:$port: {$e->getMessage()}\n");
        }
    }
}

?>