<?php
/** 
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @package WebServices
 * @subpackage Accounts
 * @copyright Waferthin Web Works LLC
 * @license http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 */
/** 
 * <i>Users</i> class
 * 
 * This class contains a hard-coded list of user accounts
 * and the corresponding passwords. This is merely a development
 * stub and should be implemented with some sort of permanent
 * storage and security.
 *
 * @package WebServices
 * @subpackage Accounts
 * @see Authentication
 * @see Authentication_HardcodedAccounts
 * @author Dirk Merkel <dirk@waferthin.com> 
 * @version 0.6
 * @since r15
 */
class Users
{
    /**
     * hard-coded user accounts
     *
     * @access private
     * @static
     * @var array $accounts user name => password mapping
     */
    private static $accounts = array('dirk'        => 'myPass',
                                     'albert'    => 'einstein');
                            
    /**
     * static validate method
     *
     * Given a user name and password, this method decides
     * whether the user has a valid account and whether
     * he/she supplied the correct password.
     *
     * @see Authentication_HardcodedAccounts::login()
     * @access public
     * @static
     * @param string $user account user name
     * @param string $password account password
     * @return boolean
     */
    public static function validate($user, $password)
    {
        return self::$accounts[$user] == $password;
    }
    
    /**
     * magic __call method
     *
     * This method only implements a magic validate method
     * where the second part of the method name is the user's
     * account name.
     *
     * @see Authentication_HardcodedAccounts::login()
     * @see validate()
     * @access public
     * @method boolean validate<user>() validate<user>(string $password) validate a user
     * @staticvar array $accounts used to validate users & passwords
     */
    public function __call($name, $arguments)
    {
        if (preg_match("/^validate(.*)$/", $name, $matches) && count($arguments) > 0) {
            return self::validate($matches[1], $arguments[0]);
        }
    }
}

?>