<?php

//create by komsan 13/07/2558
class Jobs_items extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array('../public/bootstrap-datetimepicker/css/bootstrap-datepicker3.css');
        $this->view->js = array('service/js/default.js',
            '../public/bootstrap-datetimepicker/js/bootstrap-datepicker.js',
            '../public/bootstrap-datetimepicker/locales/bootstrap-datepicker.th.min.js'
        );
    }

    function index() {
//        $this->view->getDepart = $this->getDepart();
//        $this->view->getServiceStatus = $this->getServiceStatus();
//        $this->view->getHardwareType = $this->getHardwareType();
//        $this->view->rander('service/index');
    }

    function xhrGetSelect() {
        $data = $this->model->xhrGetSelect();
        for ($i = 0; $i < sizeof($data); $i++) {
            $valname = $this->getPersonNameById($data[$i]['jobs_staff']);
            $data[$i]['jobs_staff_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];
        }
        echo json_encode($data);
    }

    function xhrSelectById() {
        $data = $this->model->xhrSelectById();
        for ($i = 0; $i < sizeof($data); $i++) {
            $valname = $this->getPersonNameById($data[$i]['jobs_staff']);
            $data[$i]['jobs_staff_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];
        }
        echo json_encode($data);
    }

    //create by shikaru 28/08/2558
    public function getPersonNameById($person_id) {
        $this->loadModel('technician');
        return $this->model->getPersonNameById($person_id);
    }
    
    function xhrSelectByServiceId($service_id){ //use for Service
        return $this->model->xhrSelectByServiceId($service_id);
    }

    function xhrInsert($arr) {
        $this->model->xhrInsert($arr);
    }

    function xhrEditById() {
        $this->model->xhrUpdateById();
    }

    function xhrUpdateState() {
        $this->model->xhrUpdateServiceStatus();
        //$this->model->xhrInsertServiceStatusDetail();
    }

    function xhrDeleteById() {
        $data = array('chk' => $this->model->xhrCheckUseById(), 'sta' => 'del');
        if ($data['chk']) {
            $this->model->xhrDeleteById();
        }
        echo json_encode($data);
    }

    public function getPartsItems() {
        //$this->loadModel('parts_items');
        return $this->model->xhrGetSelect();
    }

    function Pagination() {
        $this->model->Pagination();
    }

}
