<?php

class Authentication_HardcodedAccounts extends Authentication
{
    private $users;

    public function __construct()
    {
        $this->users = new Users();
    }
    
    public function login($user, $password)
    {
        if (empty($user) || empty($password)) {
            return false;
        } else {

            // both validation methods should work ...

            // user static method to validate account
            $firstValidation = Users::validate($user, $password);

            // use magic method validate<username>($password)
            $userLoginFunction = 'validate' . $user;
            $secondValidation = $this->users->$userLoginFunction($password);

            return ($firstValidation && $secondValidation);
        }
    }
}

?>