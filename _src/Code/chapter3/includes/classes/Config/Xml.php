<?php

class Config_Xml implements Configurable
{
    private static $instance    = null;
    private $simpleXml            = null;

    private function __construct($xmlFile = null)
    {
        $this->setup($xmlFile);
    }

    public function getInstance($xmlFile = null)
    {
        if (self::$instance == null) {
            self::$instance = new Config_Xml($xmlFile);
        }

        return self::$instance;
    }

    /**
     * (non-PHPdoc)
     * @see includes/interfaces/Configurable#setup()
     * @return Object
     */
    public function setup($xmlFile = null)
    {
        $xmlStr = file_get_contents($xmlFile);

        try {
            $this->simpleXml = new SimpleXMLElement($xmlStr);
        } catch (Exception $e) {
            echo "Unable to parse XML config file (" . $xmlFile . "): " . $e->message;
        }

        return new Object();
    }

    public function getSetting($domain = 'application', $setting = '')
    {
        if (isset($this->simpleXml->$domain->$setting)) {
            return $this->simpleXml->$domain->$setting;
        } else {
            throw new Exception("Configuration setting $domain::$setting cannot be found.");
        }
    }
}

?>