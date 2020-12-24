<?php

class Cli_Options
{
    private static $instance    = null;
    private $scriptName            = null;
    private $supportedOptions    = array();
    private $optionValues        = array();
    private $arguments            = array();

    private function __construct($supportedOptions)
    {
        // require for getopt() support
        if (!function_exists('getopt')) {
            throw new Exception("getopt() is not available.");
        }

        $this->setSupportedOptions($supportedOptions);
        $this->processCommandLine();
    }

    public static function getInstance($supportedOptions = array())
    {
        if (self::$instance == null) {
            self::$instance = new Cli_Options($supportedOptions);
        }

        return self::$instance;
    }

    public function setSupportedOptions($supportedOptions)
    {
        if (!is_array($supportedOptions)) {
            throw new Exception("Supported command line options must be passed in as an array.");
        } else {
            $this->supportedOptions = $supportedOptions;
        }
    }
    
    public function getSupportedOptions()
    {
        return $this->supportedOptions;
    }
    
    public function getScriptName()
    {
        return $this->scriptName;
    }
    
    public function getArguments()
    {
        return $this->arguments;
    }
    
    public function getArgument($i = 0)
    {
        return $this->arguments[$i];
    }

    public function processCommandLine($args = null)
    {
        // if no command line was given, pull in global one
        if ($args === NULL) {
            $args = $GLOBALS['argv'];
        }

        // parse options
        $opts = getopt(implode('', $this->supportedOptions));

        // store the script name
        $this->scriptName = array_shift($args);

        // remove options from $args array
        foreach ($opts as $opt => $arg) {

            $allowed = str_replace(array(':', $opt), '', implode($this->supportedOptions));

            $max = strlen($allowed);

            $key = key(preg_grep("'^-$opt([$allowed]{0,$max}|$arg)$'", $args));

            // process option & store it
            $this->processOption($args[$key]);

            unset($args[$key]);
        }

        // reorder array keys
        $args = array_values($args);
        
        // store arguments
        $this->arguments = $args;
    }
    
    protected function processOption($option = '')
    {
        // remove dash
        if ($option{0} == '-') {
            $option{0} = '';
        }

        // does the option have an argument?
        if (strstr($option, ':')) {
            list($key, $value) = explode(':', $option, 2);
            $this->optionValues[$key] = $value;

        } else {
            $this->optionValues[$option] = true;
        }
    }

    public function getOptionValue($option)
    {
        // is the option supported?
        if (in_array($option, $this->supportedOptions) || in_array($option . ':', $this->supportedOptions)) {
            return $this->optionValues[$option];
        } else {
            throw new Exception("Unsupported option requested.");
        }
    }
}

?>