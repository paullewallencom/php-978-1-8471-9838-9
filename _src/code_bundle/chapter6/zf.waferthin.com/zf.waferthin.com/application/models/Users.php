<?php

/**
 * Model_Users
 *
 * CRUD functionality and business logic for
 * user accounts.
 *
 * @package zf_waferthin
 * @author Dirk Merkel
 **/
class Model_Users extends Zend_Db_Table_Abstract
{
    // DB table name
    protected $_name = 'users';

    // primary ID of table
    protected $_primary = 'id';

    // store feedback messages
    public $message = array();

    // constructor provided for completeness
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * This is where all the validation happens.
     * This method is consulted before inserting
     * or adding entries or directory by the user.
     */
    public function validate(Array $data = array())
    {
        $this->message = array();

        // validate login
        if (!isset($data['email'])
            || empty($data['email'])
            || !preg_match('/^[a-zA-Z0-9_\.@]{6,}$/', $data['email'])) {

            $this->message[] = 'Email is required and must consist of at least 6 alphanumeric characters.';
        }

        // validate password format
        if (!isset($data['password'])
            || empty($data['password'])
            || !preg_match('/^[a-zA-Z0-9_]{6,}$/', $data['password'])) {

            $this->message[] = 'Password is required and must consist of at least 6 alphanumeric characters.';

        // validate password was retyped correctly
        } elseif ($data['password'] != $data['password_again']) {
            
            $this->message[] = 'You did not retype the password correctly.';
        }
        
        return !count($this->message);
    }
    
    // create a new user account
    public function insert(Array $data = array())
    {
        // call insert method provided by Zend_Db_Table_Abstract
        $data['password'] = sha1($data['password']);
        return parent::insert($data);
    }
    
    // validate credentials
    public function login($email, $password)
    {
        // minimal input validation
        if (empty($email) || empty($password)) {
            return false;
        }

        // get Zend_Db_Table_Select object for query
        $select = $this->select();
        
        // construct query
        $select->where('email = ?', $email)
               ->where('password = ?', sha1($password))
               ->where('active = ?', 1)
               ->where('deleted = ?', 0);

        // did we find a result
        $row = $this->fetchRow($select);
        if (!empty($row)) {
            return $row;
        } else {
            return false;
        }
    }
}