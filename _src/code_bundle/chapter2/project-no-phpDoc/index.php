<?php

require_once('classes/Accountable.php');
require_once('classes/Authentication.php');
require_once('classes/Users.php');
require_once('classes/Authentication/HardcodedAccounts.php');

$authenticator = new Authentication_HardcodedAccounts();

// uncomment for testing
$_POST['user'] = 'dirk';
$_POST['password'] = 'myPass';

if (isset($_POST['user']) && isset($_POST['password'])) {

    $loginSucceeded = $authenticator->login($_POST['user'], $_POST['password']);

    if ($loginSucceeded === true) {
        echo "Congrats - you're in!\n";
    } else {
        echo "Uh-uh - try again!\n";
    }
}

?>