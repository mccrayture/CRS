<?php

class Uprofile extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('uprofile/js/default.js');
    }

    function index() {
        $this->loadModel('technician');
        $this->view->getPrefix = $this->model->prefixRs();
        $this->view->getPosition = $this->model->positionRs();
        $this->view->getOffice = $this->model->officeRs();
        $this->view->rander('uprofile/index');
    }
    
    //no insert

    function editByID() {
        $this->model->updatePersonByID();
    }

    
    public function getPersonById() {
        $this->loadModel('technician');
        return $this->model->getPersonalByID();
    }   
    
    public function getPosition() {
        $this->loadModel('technician');
        return $this->model->positionRs();
    }
    
    public function getOffice() {
        $this->loadModel('technician');
        return $this->model->officeRs();
    }
    
    public function getPrefix() {
        $this->loadModel('technician');
        return $this->model->prefixRs();
    }
    
    public function getImage(){
        $url = explode('/', rtrim((isset($_GET['url']) ? $_GET['url'] : null), '/'));
        $id = $url[2];
        
        // do some validation here to ensure id is safe
        header("Content-type: image/jpeg");
        echo $this->model->loadImg($id);

    }
            

    function run() {
        $this->model->run();
    }

}
