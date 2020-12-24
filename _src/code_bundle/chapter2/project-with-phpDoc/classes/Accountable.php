<?php
/** 
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @package WebServices
 * @subpackage Authentication
 * @copyright Waferthin Web Works LLC
 * @license http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 */
/** 
 * <i>Accountable</i> interface for authentication
 * 
 * Any class that handles user authentication <b>must</b>
 * implement this interface. It makes it almost
 * trivial to check whether a user is currently
 * logged in or not.
 *
 * @package WebServices
 * @subpackage Authentication
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @version 0.2
 * @since r12
 */
interface Accountable
{
    const AUTHENTICATION_ERR_MSG = 'There is no user account associated with the current session. Try logging in fist.';

    /**
     * Did the current user log in?
     * 
     * This method simply answers the question
     * "Did the current user log in?"
     * 
     * @access public
     * @return bool
     */
    public function isLoggedIn();

    /**
     * Returns user account info
     * 
     * This method is used to retrieve the account corresponding
     * to a given login. <b>Note:</b> it is not required that
     * the user be currently logged in.
     * 
     * @access public
     * @param string $user user name of the account
     * @return Account
     */
    public function getAccount($user = '');
}

?>