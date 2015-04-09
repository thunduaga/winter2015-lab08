<?php

/**
 * Secret stuff
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Gamma extends Application {

    public function __construct() {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
    }

    //-------------------------------------------------------------
    //  We could tell you what was here, but...
    //-------------------------------------------------------------

    public function index() {
        $this->data['pagebody'] = 'gamma';
        $this->render();
    }

}
