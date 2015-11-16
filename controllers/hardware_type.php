<?php

//    make by Shikaru
class Hardware_Type extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('hardware_type/js/default.js');
    }

    function index() {
        $this->view->hardwareTypeRs = $this->model->hardwareTypeRs();
        $this->view->rander('hardware_type/index');
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

}
