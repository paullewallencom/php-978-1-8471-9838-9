<?php
/**
 * Bootstrap file
 *
 * This is the form handler for the login application.
 * It expects a user name and password via _POST. If 
 *
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @package WebServices
 * @copyright Waferthin Web Works LLC
 * @license http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version 0.7
 * @since r2
 * @mytag mytag description http://waferthin.com
 */
/**
 * required class files and interfaces
 */
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