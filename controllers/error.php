<?php

class Error extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->view->msg = 'This page doesnt exits';
        $this->view->rander('error/index');        
    }
    
    function notLogin() {        
        $this->view->msg = 'Please Login...';
        $this->view->rander('error/index'); 
    }
    
    function accessDenied() {        
        $this->view->msg = 'Access Denied...';
        $this->view->rander('denied/index'); 
    }
}
