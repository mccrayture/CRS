<?php

//    make by Shikaru 
class Service_detail_status extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('service_detail_status/js/default.js');
    }

    function index() {
        $this->view->rander('service_detail_status/index');
    }

    function xhrGetSelect() {
        $data = $this->model->xhrGetSelect();
        echo json_encode($data);
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

}
