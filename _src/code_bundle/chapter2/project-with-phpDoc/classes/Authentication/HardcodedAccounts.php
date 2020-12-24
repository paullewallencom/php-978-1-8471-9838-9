<?php
/** 
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @package WebServices
 * @subpackage Authentication
 * @copyright Waferthin Web Works LLC
 * @license http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 */
/** 
 * <i>Authentication_HardcodedAccounts</i> class
 * 
 * This class implements the login method needed to handle
 * actual user authentication. It extends <i>Authentication</i>
 * and implements the <i>Accountable</i> interface.
 *
 * @package WebServices
 * @subpackage Authentication
 * @see Authentication
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @version 0.6
 * @since r14
 */
class Authentication_HardcodedAccounts extends Authentication
{
    /**
     * Referece to <i>Users</i> object
     * @access private
     * @var Users
     */
    private $users;

    /**
     * Authentication_HardcodedAccounts constructor
     *
     * Instantiates a new {@link Users} object and stores a reference
     * in the {@link users} property.
     *
     * @see Users
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->users = new Users();
    }
    
    /**
     * login method
     *
     * Uses the reference {@link Users} class to handle
     * user validation.
     *
     * @see Users
     * @todo Decide which validate method to user instead of both
     * @access public
     * @param string $user account user name
     * @param string $password account password
     * @return boolean
     */
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