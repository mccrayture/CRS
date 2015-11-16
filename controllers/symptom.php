<?php

class Symptom extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('symptom/js/default.js');
    }

    function index() {
        $this->view->getHardwareTypeRs = $this->getHardwareTypeRs();
        $this->view->rander('symptom/index');
    }

    public function getHardwareTypeRs() {
        $this->loadModel('hardware_type');
        return $this->model->hardwareTypeRs();
    }

    function getListings() {
        $this->model->getDataListings();
    }

    function insertByID() {
        $this->model->insertDataByID();
    }

    function editByID() {
        $this->model->editDataByID();
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

    function Pagination() {
        $this->model->Pagination();
    }

    
}
