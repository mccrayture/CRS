<?php

class Jobs extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('jobs/js/default.js');
    }

    function index() {
        $this->view->jobGroupRS = $this->getJobGroupRs();
        $this->view->rander('jobs/index');
    }

    public function getJobGroupRs() {
        return $this->model->jobsGroupRs();
    }

    function getListings() {
        $this->model->getDataListings();
        //$data = $this->model->getDataListings();
        //echo json_encode($data);
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
