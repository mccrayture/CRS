<?php

class Denied extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->view->msg = 'Accese Denied';
        $this->view->rander('denied/index');        
    }
    
    
}
