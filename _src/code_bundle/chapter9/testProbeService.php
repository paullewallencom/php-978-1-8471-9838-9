<?php

class ProbeService
{
    // port to probe
    public $port = 80;

    // host to probe
    public $host = 'google.com';

    // map of port numbers to common service names
    public $serviceName = array(23  => 'telnet',
                                25  => 'smtp',
                                80  => 'http',
                                110 => 'pop3',
                                443 => 'https'
                                );
                                
    // maximum number of probes allowed per host per port
    protected $maxProbes = null;
    
    // multi-dimensional array storing the number
    // of probes per host per port
    protected $probeCount = array();
    
    // constructor initializes maxProbes to 3
    public function __construct($maxProbes = 3)
    {
        $this->maxProbes = $maxProbes;
    }
    
    // probe host and port
    public function probe($host, $port)
    {
        // save port and host for other methods to access
        $this->host = $host;
        $this->port = $port;
        
        try {
            
            // get a list of IP addresses associated with the host
            $ipAddresses = $this->resolveHost();

            // iterate over all found IP addresses
            foreach ($ipAddresses as $ip) {
                
                // check max probing limit
                if ($this->probeCount[$this->host][$this->port] < $this->maxProbes) {

                    // increment the number of times this host & port were probed
                    $this->increasePortCount();

                    // got a responsive port
                    if ($this->tcpConnection()) {

                        echo "$this->host is responding on port $this->port.";

                        // try to look up the service name base on the port number
                        if (array_key_exists($this->port, $this->serviceName)) {
                            echo " This port is typically associated with the {$this->serviceName[$this->port]} service.\n";
                        } else {
                            echo " Unfortunately, we don't have a name for the service responding on that port.\n";
                        }
                        break;

                    // unable to establish a connection
                    } else {
                        echo "The host $this->host is not responding on port $this->port.\n";
                    }
                    
                // throw max number of probes exceeded exception
                } else {
                    throw new Exception("Maximum probe limit of $this->maxProbes exceeded for host $this->host on port $this->port.");
                }
            }

        // catch exceptions and notify user
        } catch (Exception $e) {
            exit("Unable to probe $this->host:$this->port: {$e->getMessage()}");
        }
    }
    
    // lookup IP addresses corresponding to a given host name
    protected function resolveHost()
    {
        if ($ipAddresses = gethostbynamel($this->host)) {
            return $ipAddresses;
        } else {
            throw new Exception('Unable to resolve host ' . $this->host . '. Check network connection and validity of host name.');
        }
    }
    
    // method to keep track of connections by host & port
    protected function increasePortCount()
    {
        // check whether an entry already exists
        if (array_key_exists($this->host, $this->probeCount)
            && array_key_exists($this->port, $this->probeCount[$this->host])) {
                
                $this->probeCount[$this->host][$this->port]++;

            // create new entry
            } else {
                $this->probeCount[$this->host][$this->port] = 1;
            }
    }
    
    // attempt to open socket connection
    protected function tcpConnection()
    {
        // try to open a socket
        $socket = fsockopen($this->host, $this->port, $errorNumber, $errorString, 30);

        // unable to open socket
        if (!$socket) {
            return FALSE;
        
        // success!
        } else {

            // gracefully close the connection & return true
            fclose($socket);

            return TRUE;
        }
    }
}

$probe = new ProbeService(3);
$probe->probe('yahoo.com', 80);

?>