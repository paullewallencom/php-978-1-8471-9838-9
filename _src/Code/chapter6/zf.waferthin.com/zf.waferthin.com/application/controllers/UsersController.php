<?php

// ZF MVC controller class for users module
class UsersController extends Zend_Controller_Action
{
    public $log = null;

    // controller initialization
    public function init()
    {
        // get local reference to logger object
        $this->log = $this->getInvokeArg('bootstrap')->getResource('log');
    }

    // this method will be called is no action was
    // specified in the URL
    public function indexAction()
    {
        // forward to login
        $this->_redirect('/users/login');
    }

    public function signupAction()
    {
        // get request object
        $request = $this->getRequest();
        
        // handle new signups
        if ($request->isPost()) {
            
            // instantiate users model
            $users = new Model_Users();

            // get submitted data
            $record = $request->getParams();
            
            // validate data before inserting
            if ($users->validate($record)) {
            
                // remove data we don't need
                unset($record['password_again'],
                    $record['Submit'],
                    $record['controller'],
                    $record['action'],
                    $record['module']);
        
                // create the new record
                try {
                    $users->insert($record);

                    // account created confirmation message
                    $this->view->message = array('The account for ' . $record['email'] . ' has been created successfully.');
                
                    // send confirmation email
                    $this->sendConfirmationEmail($record['email'],
                                                 $record['first_name'] . ' ' . $record['last_name'],
                                                 'admin@zf.waferthin.com',
                                                 'Admin',
                                                 'Account Created',
                                                 'confirm_email.phtml');
                    
                // something went wrong
                } catch (Exception $e) {
                    
                    // log the problem ...
                    $this->log->info('Unable to create new user account: ' . $record['email'] . "\nError message: " . $e->getMessage());
                
                    // .. and notify the user
                    $this->view->message = array('An error occurred. The account for ' . $record['email'] . ' could not be created.');
                }

            // validation failed
            } else {

                // assign parameters back to view
                $this->view->params = $record;

                // assign success / failure message to view
                $this->view->message = $users->message;
            }
        }
    }

    public function loginAction()
    {
        // get request object
        $request = $this->getRequest();

        // handle login request
        if ($request->isPost()) {

            // instantiate users model
            $users = new Model_Users();

            // validate credentials
            if ($user = $users->login($request->getParam('email'), $request->getParam('password'))) {
                    
                // log successful login ...
                $this->log->info('Login success: ' . $request->getParam('email'));

                // show welcome message
                $this->view->message = array('Welcome back, ' . $user['first_name'] . ' ' . $user['last_name'] . '. You have successfully logged in.');

            // credentials not accepted
            } else {
                    
                // log unsuccessful login attempt ...
                $this->log->info('Unsuccessful login attempt: ' . $request->getParam('email'));

                // ... and display error message
                $this->view->message = array('Your email or password do not correspond to an active user account. Please try again or <a href="/users/signup">signup</a>');

                // assign parameters back to view
                $this->view->params = $request->getParams();
            }
        }
    }
    
    // send email with body of message rendered with Zend_View
    protected function sendConfirmationEmail($recipientEmail,
                                             $recipientName,
                                             $senderEmail,
                                             $senderName,
                                             $subject,
                                             $emailViewName)
    {
        // create a view
        $view = new Zend_View();
        
        // tell view where to look for templates
        $view->setScriptPath(APPLICATION_PATH . '/views/scripts/users/');
        
        // assign an array of key-value pairs to be rendered in view
        $info = array(
                        'recipientName' => $recipientName,
                        'recipientEmail' => $recipientEmail
                        );
        $view->assign($info);
        
        // render view
        $message = $view->render($emailViewName);
        
        // instantiate Zend_Mail obmect
        $mail = new Zend_Mail();
        
        // use fluid interface to send confirmation message
        $mail->setBodyText($message)
            ->setFrom($senderEmail, $senderName)
            ->addTo($recipientEmail, $recipientName)
            ->setSubject($subject)
            ->send();

        // log email sent
        $this->log->info('Sent email template ' . $emailViewName . ' to ' . $recipientEmail);
    }
}