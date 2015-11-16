<?php

//    make by Shikaru
class Store extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array('../public/bootstrap-datetimepicker/css/bootstrap-datepicker3.css');
        $this->view->js = array(
            'store/js/default.js',
            'service/js/ThaiBaht.js',
            '../public/bootstrap-datetimepicker/js/bootstrap-datepicker.js',
            '../public/bootstrap-datetimepicker/locales/bootstrap-datepicker.th.min.js'
        );
    }

    function index() {
        $this->view->getStoreType = $this->getStoreType();
        $this->view->rander('store/index');
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
        $data = array('chk' => $this->model->xhrCheckUseById());
        if ($data['chk']) {
            $this->model->xhrDeleteById();
        }
        echo json_encode($data);
    }

    public function getStoreType() {
        $this->loadModel('store_type');
        return $this->model->storeTypeRs();
    }
    
    //create by opol
    function Pagination() {
        $this->model->Pagination();
    }
}
