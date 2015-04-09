<?php

/**
 * Controller for handling user authentication.
 */
class Auth extends Application
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['pagebody'] = 'login';
        $this->render();
    }
    
    public function submit()
    {
        $keyID = $_POST['userid'];
        
        $password = $_POST['password'];
        $user = $this->users->get($keyID);

         if (password_verify($password, $user->password))
        {
            $this->session->set_userdata('userID', $keyID);
            
            $this->session->set_userdata('userName', $user->name);
            
            $this->session->set_userdata('userRole', $user->role);
        }
        redirect('/');
    }

    /**
    * Destroy user session.
    */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
