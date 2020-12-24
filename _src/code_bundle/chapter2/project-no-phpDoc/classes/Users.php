<?php

class Users
{
    private static $accounts = array('dirk'        => 'myPass',
                                     'albert'    => 'einstein');
                            
    public static function validate($user, $password)
    {
        return self::$accounts[$user] == $password;
    }
    
    public function __call($name, $arguments)
    {
        if (preg_match("/^validate(.*)$/", $name, $matches) && count($arguments) > 0) {
            return self::validate($matches[1], $arguments[0]);
        }
    }
}

?>