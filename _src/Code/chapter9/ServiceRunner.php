<?php

require_once('interfaces/Interrogator.php');
require_once('classes/Probe.php');
require_once('classes/ProbeService.php');
require_once('classes/Connection.php');

class ServiceRunner
{
    public $host            = null;
    public $startPort        = null;
    public $endPort            = null;
    protected $connections    = array();
    
    // constructor take host and port range
    public function __construct($host = 'localhost', $startPort = 0, $endPort = 65535)
    {
        $this->host = $host;
        $this->startPort = $startPort;
        $this->endPort = $endPort;
    }

    // run the port scan
    public function run()
    {
        // get a list of IP addresses associated with the host
        $ipAddresses = $this->resolveHost($this->host);

        // iterate over all found IP addresses ...
        foreach ($ipAddresses as $ip) {
            
            // ... also iterate over the whole port range
            for ($port = $this->startPort; $port <= $this->endPort; $port++) {
            
                $probeService = new ProbeService();
            
                // did the connection attempt succeed?
                if ($connection = $probeService->probe($ip, $port)) {

                    $this->connections[] = $connection;
                }
            }
        }
    }
    
    // output results of scan
    public function output()
    {
        echo "Results for scanning host $this->host:\n\n";

        foreach ($this->connections as $connection) {

            echo "Host: $connection->ip on port $connection->port: ";

            // try to look up the service name based on the port number
            if (array_key_exists($connection->port, ProbeService::$serviceName)) {
                echo " this port is typically associated with the " . ProbeService::$serviceName[$port] . " service.\n";
            } else {
                echo " unfortunately, we don't have a name for the service responding on that port.\n";
            }
        }
    }
    
    // lookup IP addresses corresponding to a given host name
    protected function resolveHost($host)
    {
        if ($ipAddresses = gethostbynamel($host)) {
            return $ipAddresses;
        } else {
            throw new Exception('Unable to resolve host ' . $host . '. Check network connection and validity of host name.');
        }
    }
}

$runner = new ServiceRunner('google.com', 80, 81);
$runner->run();
$runner->output();

?>