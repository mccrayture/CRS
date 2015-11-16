<?php

//    make by Shikaru
class Expose extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array('../public/bootstrap-datetimepicker/css/bootstrap-datepicker3.css');
        $this->view->js = array('expose/js/default.js',
            '../public/bootstrap-datetimepicker/js/bootstrap-datepicker.js',
            '../public/bootstrap-datetimepicker/locales/bootstrap-datepicker.th.min.js'
        );
    }

    function index() {
        $this->view->getStore = $this->getStore();
        $this->view->rander('expose/index');
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

    public function getStore() {
        $this->loadModel('store');
        return $this->model->storeRs();
    }

    function Pagination() {
        $this->model->Pagination();
    }

}
