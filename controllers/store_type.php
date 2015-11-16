<?php

//    make by Shikaru
class Store_Type extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('store_type/js/default.js');
    }

    function index() {
        $this->view->rander('store_type/index');
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
