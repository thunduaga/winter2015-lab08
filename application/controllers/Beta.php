<?php

/**
 * Our registered users' content. 
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Beta extends Application {

    public function __construct() {
        parent::__construct();
        $this->restrict(array(ROLE_USER, ROLE_ADMIN));
    }

    //-------------------------------------------------------------
    //  Stuff that should only be seen by logged in users
    //-------------------------------------------------------------

    public function index() {
        $this->data['pagebody'] = 'beta';
        $this->render();
    }

}
