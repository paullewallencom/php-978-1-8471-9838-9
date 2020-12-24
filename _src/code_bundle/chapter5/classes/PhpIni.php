<?php

class PhpIni
{
    // initialize current development to null
    public $environment = null;
    
    // initialize location of config file(s) to empty array
    public $configDirs = array();
    
    // initialize active settings to empty array
    public $activeSettings = array();
    
    // define default settings for each environment defined
    // by this class (can be overriden later)
    public $defaultSettings = array();

    // constructor sets the location of the config files
    public function __construct(array $configDirs = array())
    {
        if (count($configDirs) > 0) {
            $this->configDirs = $configDirs;
        }
    }
    
    // applies the settings for the current environment
    // optionally overrides defaults with custom settings
    public function applySettings(array $customSettings = array())
    {
        // reset current settings
        $this->activeSettings = array();
        
        // get list of ini files
        $iniFiles = $this->getIniFiles();
    
        // initialize default settings
        $this->defaultSettings = array();
        
        // read all ini files
        foreach ($iniFiles as $iniFile) {
            // merge all default settings
            $this->defaultSettings = array_merge($this->defaultSettings, parse_ini_file($iniFile, TRUE));
        }

        // merge ini files with custom settings
        $this->activeSettings = array_merge($this->defaultSettings[$this->environment], $customSettings);
        
        // apply settings
        foreach ($this->activeSettings as $directive => $value) {
            ini_set($directive, $value);
        }
    }
    
    // returns array of all config directories
    public function getConfigDirs()
    {
        $this->configDirs = $configDirs;
    }
    
    // set array of config directories at once
    public function setConfigDirs(array $configDirs = array())
    {
        return $this->configDirs;
    }
    
    // push a directory onto the end of configDirs array
    public function addConfigDir($newConfigDir)
    {
        array_push($this->configDirs, $newConfigDir);
    }
    
    // returns the currently set environment
    public function getEnvironment()
    {
        return $this->environment;
    }
    
    // set the current environment
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }
    
    // return the default setting in a given environment (or current one)
    // throws an exception if either environment or setting are undefined
    public function getDefaultSetting($setting, $environment = null)
    {
        // use current environment if none given
        if ($environment === null) {
            $environment = $this->getEnvironment();
        }
        
        // check whether the environment exists
        if (!array_key_exists($environment, $this->defaultSettings)) {
            throw new Exception("Environment '$environment' not defined.");

        // check whether the setting exists
        } elseif (!array_key_exists($setting, $this->defaultSettings[$environment])) {
            throw new Exception("Default setting '$setting' in environment '$environment' is not defined.");
            
        // return the requested default setting
        } else {
            return $this->defaultSettings[$environment][$setting];
        }
    }
    
    // return the value of the setting how it was actually set
    // WARNING: only works if setting was set with this class
    public function getActiveSetting($setting)
    {
        // check whether the setting exists
        if (!array_key_exists($setting, $this->activeSettings)) {
            throw new Exception("Setting '$setting' is not currently defined throug __CLASS__.");
            
        // return the requested setting
        } else {
            return $this->activeSettings[$setting];
        }
    }
    
    // given all directories in configDirs, this method finds
    // and returns all files ending in .ini in those directories
    public function getIniFiles()
    {
        // initialize array of ini files
        $iniFiles = array();
        
        // loop over directories
        foreach ($this->configDirs as $dir) {
            
            if (is_dir($dir)) {

                // open directory ...
                if ($dirHandle = opendir($dir)) {
                
                    // ... and iterate of the file therein
                    while (($file = readdir($dirHandle)) !== FALSE) {
                
                        // check file extension
                        $pathParts = pathinfo($dir . DIRECTORY_SEPARATOR . $file);
                        if ($pathParts['extension'] == 'ini') {
                            
                            // we found a .ini file
                            $iniFiles[] = $dir . DIRECTORY_SEPARATOR . $file;
                        }
                    }
                    closedir($dirHandle);
                }
            }
        }

        return $iniFiles;
    }
}

?>