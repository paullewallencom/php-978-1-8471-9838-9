<?php

abstract class Authentication implements Accountable
{
    private $account = null;
    
    public function getAccount($user = '')
    {
        if ($this->account !== null) {
            return $this->account;
        } else {
            return AUTHENTICATION_ERR_MSG;
        }
    }
    
    public function isLoggedIn()
    {
        return ($this->account !== null);
    }
    
    abstract public function login($user, $password);
}

?>