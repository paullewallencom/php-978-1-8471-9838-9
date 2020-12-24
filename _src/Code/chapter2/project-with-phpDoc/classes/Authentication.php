<?php
/** 
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @package WebServices
 * @subpackage Authentication
 * @copyright Waferthin Web Works LLC
 * @license http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 */
/** 
 * <i>Authentication</i> handles user account info and login actions
 * 
 * This is an abstract class that serves as a blueprint
 * for classes implementing authentication using
 * different account validation schemes. 
 *
 * @see Authentication_HardcodedAccounts
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @package WebServices
 * @subpackage Authentication
 * @version 0.5
 * @since r5
 */
abstract class Authentication implements Accountable
{
    /**
     * Reference to Account object of currently
     * logged in user.
     *
     * @access private
     * @var Account
     */
    private $account = null;
    
    /**
     * Returns account object if valid.
     *
     * @see Accountable::getAccount()
     * @access public
     * @param string $user user account login
     * @return Account user account
     */
    public function getAccount($user = '')
    {
        if ($this->account !== null) {
            return $this->account;
        } else {
            return AUTHENTICATION_ERR_MSG;
        }
    }
    
    /**
     * isLoggedIn method
     *
     * Says whether the current user has provided
     * valid login credentials.
     *
     * @see Accountable::isLoggedIn()
     * @access public
     * @return boolean
     */
    public function isLoggedIn()
    {
        return ($this->account !== null);
    }
    
    /**
     * login method
     *
     * Abstract method that must be implemented when
     * sub-classing this class.
     *
     * @access public
     * @return boolean
     */
    abstract public function login($user, $password);
}

?>