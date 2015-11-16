<?php

//    make by Shikaru
class Items extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array('../public/bootstrap-datetimepicker/css/bootstrap-datepicker3.css'
            ,'../public/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'
            , '../public/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css');
        $this->view->js = array('items/js/default.js',
            '../public/bootstrap-datetimepicker/js/bootstrap-datepicker.js',
            '../public/bootstrap-datetimepicker/locales/bootstrap-datepicker.th.min.js'
        );
    }

    function index() {
        $this->view->getItemsCode = $this->getItemsCode();
        $this->view->getHardware = $this->getHardware();
        $this->view->getDepart = $this->getDepart();
        $this->view->rander('items/index');
    }

    function xhrGetSelect() {
        $this->model->xhrGetSelect();
    }

    function xhrSelectById() {
        $this->model->xhrSelectById();
    }

    function xhrInsert() {
        $this->model->xhrInsert();
    }

    function xhrEditById() {
        $this->model->xhrUpdateById();
    }

    function xhrDeleteById() {
        $data = array('chk' => $this->model->xhrCheckUseById(), 'sta' => 'del');
        if ($data['chk']) {
            $this->model->xhrDeleteById();
        }
        echo json_encode($data);
    }

    public function getHardware() {
        $this->loadModel('hardware');
        return $this->model->hardwareRs();
    }

    public function getDepart() {
        $this->loadModel('depart');
        return $this->model->departRs();
    }
    
     public function getItemsCode() {
        return $this->model->itemsCodeRs();
    }
    
    function Pagination() {
        $this->model->Pagination();
    }

}
