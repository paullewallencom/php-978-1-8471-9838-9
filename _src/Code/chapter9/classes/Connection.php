<?php

class Connection
{
    // port to probe
    public $port = 80;

    // ip to probe
    public $ip = '127.0.0.1';

    // reference to socket
    private $socket = null;
    
    // current state of socket
    private $socketOpen = FALSE;
    
    // constructor sets ip and port number
    public function __construct($ip, $port)
    {
        $this->ip = $ip;
        $this->port = $port;
    }
    
    // get socket connection status
    public function isSocketOpen()
    {
        return $this->socketOpen;
    }
    
    // gracefully close socket
    public function close()
    {
        // make sure we have an open socket to close
        if ($this->socketOpen) {
            return fclose($this->socket);
        } else {
            return FALSE;
        }
    }

    // get a reference to the socket
    public function getSocket()
    {
        return $this->socket;
    }
    
    // open a socket connection
    public function connect()
    {
        // try to open a socket
        $socket = fsockopen($this->ip, $this->port, $errorNumber, $errorString, 30);

        // unable to open socket
        if (!$socket) {

            $this->socketOpen = FALSE;
            return FALSE;
        
        // success!
        } else {

            // store the socket for later
            $this->socket = $socket;

            return TRUE;
        }
    }
}

?>