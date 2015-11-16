<?php

//    make by Shikaru
class Parts extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array('../public/bootstrap-datetimepicker/css/bootstrap-datepicker3.css');
        $this->view->js = array('service/js/default.js',
            '../public/bootstrap-datetimepicker/js/bootstrap-datepicker.js',
            '../public/bootstrap-datetimepicker/locales/bootstrap-datepicker.th.min.js'
        );
    }

    function index() {
        $this->view->getDepart = $this->getDepart();
        $this->view->getServiceStatus = $this->getServiceStatus();
        $this->view->getHardwareType = $this->getHardwareType();
        $this->view->rander('service/index');
    }

    function xhrGetSelect() {
        $this->model->xhrGetSelect();
    }

    function xhrSelectById() {
        $this->model->xhrSelectById();
    }

    function xhrInsert($staff = null) {
        $this->model->xhrInsert($staff);
    }

    function xhrEditById() {
        $this->model->xhrUpdateById();
    }
    
    function xhrUpdateState() {
        $this->model->xhrUpdateServiceStatus();
        $this->model->xhrInsertServiceStatusDetail();
    }

    function xhrDeleteById() {
        $data = array('chk' => $this->model->xhrCheckUseById(), 'sta' => 'del');
        if ($data['chk']) {
            $this->model->xhrDeleteById();
        }
        echo json_encode($data);
    }
    
    
    
    
    
    

    public function getDepart() {
        $this->loadModel('depart');
        return $this->model->departRs();
    }

    public function getServiceStatus() {
        $this->loadModel('service_status');
        return $this->model->serviceStatusRs();
    }

    public function getServiceDetailStatus() {
        $this->loadModel('service_detail_status');
        $data = $this->model->xhrGetSelect();
        echo json_encode($data);
//        return $this->model->xhrGetSelect();
    }

    public function getSymptom() {
        $this->loadModel('symptom');
        $data = $this->model->symptomRs();
        echo json_encode($data);
    }

    public function getHardware() {
        $this->loadModel('hardware');
        $data = $this->model->hardwareRs();
        echo json_encode($data);
    }

    public function getHardwareType() {
        $this->loadModel('hardware_type');
        return $this->model->hardwareTypeRs();
    }

    public function getItems() {
        $this->loadModel('items');
        return $this->model->xhrGetSelect();
    }

    public function getPerson() {
        $this->loadModel('technician');
        return $this->model->personalRs();
    }

    //create by komsan 09/06/2558
    public function getPersonById() {
        $this->loadModel('technician');
        return $this->model->getPersonalByID();
    }

    function Pagination($model = NULL) {
        if ($model) {
            $this->loadModel($model);
        }
        $this->model->Pagination();
    }

}
