<?php

// use of require_once
require_once('logging/Database/DbLogger.php');

class DbConnector
{
    // these are the RDBMs we support
    public static $supportedDbVendords = array('mysql',
                                                'oracle',
                                                'mssql');

    // factory method using include_once
    public static function makeDbConnection($dbVendor = 'mysql')
    {
        if (in_array($dbVendor, self::$supportedDbVendords)) {
            
            // construct the class name from the DB vendor name
            $className = ucfirst($dbVendor);
            include_once 'database/drivers/' .
                        $className . '.php';
            
            return new $className();
            
        } else {
            
            // unsupported RDBMs -> throw exception
            throw new Exception('Unsupported RDBSs: ' . $dbVendor);
        }
    }
}

// use factory method to get DB connection
$dbHandle = MakeAnObject::makeDbConnection();

?>