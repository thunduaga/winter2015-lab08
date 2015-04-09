<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = "Top Secret Government Site";    // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
    }

    /**
     * Render this page
     */
    public function render() {
        //$this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'),true);
        $this->data['menubar'] = $this->makemenu();

        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        //$this->data['sessionid'] = session_id();
        $this->data['id'] = $this->session->userdata('userID');
        $this->data['user'] = $this->session->userdata('userName');
        $this->data['role'] = $this->session->userdata('userRole');
        $this->parser->parse('_template', $this->data);
    }

    public function restrict($roleNeeded = null)
    {
        if ($roleNeeded != null)
        {
            $userRole = $this->session->userdata('userRole');
            if (is_array($roleNeeded))
            {
                if (!in_array($userRole, $roleNeeded))
                {
                    redirect('/');
                    return;
                }
            }
            else if ($userRole != $roleNeeded)
            {
                redirect('/');
                return;
            }
        }
    }
     /**
 * Genereates the menu according to the user's login status and role.
 */
    public function makemenu()
    {
        // Get the user's name and role.
        $userName = $this->session->userdata('userName');
        $userRole = $this->session->userdata('userRole');

        $menubar = array('menudata' => array());
        $choices = array();

        // Accessible for everyone.
        $choices[] = 'Alpha';

        if ($userName == null)
        {
            // Show login option if not logged in.
            $choices[] = 'Login';
            $menubar['status'] = "You are not logged in.";
        }
        else
        {
            // Show logout option if logged in.
            $choices[] = 'Logout';
            $menubar['status'] = "You are logged in as $userName.";

            switch ($userRole)
            {
                case ROLE_ADMIN:
                // Logged in as admin.
                $choices[] = 'Gamma';
                // Fall through.

                case ROLE_USER:
                // Logged in as user.
                $choices[] = 'Beta';
                break;
            }
        }


        // Create menudata from available choices.
        foreach ($this->config->item('menu_choices') as $choice)
        {
            if (in_array($choice['name'], $choices))
            {
                $menubar['menudata'][] = $choice;
            }
        }

        return $this->parser->parse('_menubar', $menubar, true);
    }
}
