<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
                        'namespace' => '',
                        'basePath'  => dirname(__FILE__),
                        ));

        return $autoloader;
    }

    // bootstrap log resource
    protected function _initLog()
    {
        // construct path to log file; name includes environment
        $logFile = realpath(APPLICATION_PATH . '/../../logs/') . DIRECTORY_SEPARATOR . APPLICATION_ENV . '.log';

        // create writer object needed by Zend_Log
        $writer = new Zend_Log_Writer_Stream($logFile);
        
        // instantiate Zend_Log and tell it to write to log file
        $log = new Zend_Log($writer);

        return $log;
    }
}
   