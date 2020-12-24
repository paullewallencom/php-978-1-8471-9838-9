<?php

// include PhpIni class
require_once('classes/PhpIni.php');

// instantiate PhpIni object
$phpIni = new PhpIni(array('/Users/dirk/Documents/Work/WaferThin/Packt/Book/Code/chapter6/config'));

// set the environment
$phpIni->setEnvironment('DEVELOPMENT');

// apply all settings from the .ini files,
// but override config setting 'error_log' with a custom value
$phpIni->applySettings(array('error_log' => '/custom/dir/for/project/php_errors.txt'));

// output information about the environment
echo "Current environment (" . $phpIni->getEnvironment() . "): "
    . $phpIni->getActiveSetting('description') . "\n";
    
// current setting for 'error_log'
echo "Current setting for 'error_log' in this environment: "
    . $phpIni->getActiveSetting('error_log') . "\n";

// default setting for 'error_log' in current environment (DEVELOPMENT)
echo "Default setting for 'error_log' in this environment: "
    . $phpIni->getDefaultSetting('error_log') . "\n";

// default setting for 'error_log' in inactive  environment PRODUCTION
echo "Default setting for 'error_log' in Production environment: "
    . $phpIni->getDefaultSetting('error_log', 'PRODUCTION') . "\n";

?>