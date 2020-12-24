<?php

interface Accountable
{
    const AUTHENTICATION_ERR_MSG = 'There is no user account associated with the current session. Try logging in fist.';

    public function isLoggedIn();
    public function getAccount($user = '');
}

?>