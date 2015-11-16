<?php

class Technician extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('technician/js/default.js');
        $this->view->css = array('../public/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'
            ,'../public/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css');
    }

    function index() {
        $this->view->rander('technician/index');
    }

    function technician() {
        $this->model->technician();
    }
    
    function getListings() {  
        $data = $this->model->getDataListings();
        echo json_encode($data);
    }

    function insertByID() {
//        $this->model->insertDataByID();
    }

    function editByID() {
//        $this->model->editDataByID();
    }
    
    function updateTecnician() {
        $this->model->updateTecnicianByID();
    }
    
    function deleteByID() {
        
        $data = array('chk' => $this->checkUseByID());
        if ($data['chk']) {
            $this->model->deleteDataByID();
        }
        echo json_encode($data);
        
    }

    function getByID() {
        $this->model->getDataByID();
    }

    function checkUseByID() {
       return $this->model->checkDataUseByID();
    }
    
    public function getPerson() {
        $this->model->personalRs();
    }
    
    function Pagination() {
        $this->model->Pagination();
    }

}
