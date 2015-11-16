<?php

//create by komsan 13/07/2558
class Parts_items extends Controller {

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
        echo json_encode($data);
    }

    function xhrSelectById() {
        $this->model->xhrSelectById();
    }

    function xhrSelectByServiceId($service_id) { //use for Service
        return $this->model->xhrSelectByServiceId($service_id);
    }

    function xhrInsertPart() {
        // var_dump($_POST['arrJobs']);
//        $arrParts = $this->convertToPureArray($_POST['arrParts']);
//        $arrJobs = $this->convertToPureArray($_POST['arrJobs']);
        $arrParts = $_POST['arrParts'];
        $arrJobs = $_POST['arrJobs'];
        $result = true;
        $result2 = true;
        $resultJobsParts = true;

        if (sizeof($_POST['arrParts']) > 0) {
            foreach ($arrParts as $k => $v) {

                if (isset($v["manage"])) {
                    $service_id = $v["service_id"];
                    $staff = $v['parts_modified'];
                    $choice = strtoupper($v["manage"]);
                    if ($choice === 'NEW') {
                        $this->loadModel('parts_items');
                        $result = $this->xhrInsert($v);
                        if ($resultJobsParts !== false) {
                            $resultJobsParts = $result;
                        }

                        $result2 = $this->xhrUpdateParts($v["store_id"], $v["parts_qty"], 'sub');
                        if ($resultJobsParts !== false) {
                            $resultJobsParts = $result2;
                        }
                    } elseif ($choice === 'EDIT') {
                        $this->loadModel('parts_items');
                        $result = $this->xhrUpdateById($v);
                        if ($resultJobsParts !== false) {
                            $resultJobsParts = $result;
                        }

                        if ($v["parts_qty"] >= $v["parts_qty_old"]) {
                            $num = $v["parts_qty"] - $v["parts_qty_old"];
                            $event = 'sub';
                        } else {
                            $num = $v["parts_qty_old"] - $v["parts_qty"];
                            $event = 'add';
                        }
                        $result2 = $this->xhrUpdateParts($v["store_id"], $num, $event);
                        if ($resultJobsParts != false) {
                            $resultJobsParts = $result2;
                        }
                    } elseif ($choice === 'DELETE') {
                        $this->loadModel('parts_items');
                        $result = $this->xhrDeleteById($v["parts_items_id"]);
                        if ($resultJobsParts != false) {
                            $resultJobsParts = $result;
                        }

                        $result2 = $this->xhrUpdateParts($v["store_id"], $v["parts_qty"], 'add');
                        if ($resultJobsParts !== false) {
                            $resultJobsParts = $result2;
                        }
                    }
                }
            }
        }

        if (sizeof($_POST['arrJobs']) > 0) {
            foreach ($arrJobs as $k => $v) {
                if (isset($v["manage"])) {
                    $service_id = $v["service_id"];
                    $staff = $v['jobs_modified'];
                    $choice = strtoupper($v["manage"]);
                    if ($choice === 'NEW') {
                        $result = $this->xhrInsertJobs($v);
                        if ($resultJobsParts !== false) {
                            $resultJobsParts = $result;
                        }
                    } elseif ($choice === 'EDIT') {
                        $result = $this->xhrUpdateJobs($v);
                        if ($resultJobsParts !== false) {
                            $resultJobsParts = $result;
                        }
                    } elseif ($choice === 'DELETE') {
                        $result = $this->xhrDeleteJobs($v["jobs_items_id"]);
                        if ($resultJobsParts !== false) {
                            $resultJobsParts = $result;
                        }
                    }
                }
            }
        }
############## Update Service Status [Begin]
        /* komsan close option, user not required
        if ($service_id) {
            $this->loadModel('service');
            $this->model->xhrUpdServiceDetail(
                    array('service_id' => "{$service_id}",
                        'service_detail_status_id' => '3',
                        'service_detail_datetime' => date('Y-m-d H:i:s'),
                        'service_detail_user' => "{$staff}",
                        'service_detail_detail' => ''));
        }

         */
############## Update Service Status [End]


        $data = array('resultUpdateJobsParts' => $resultJobsParts);
        echo json_encode($data);
    }

    private function convertToPureArray($postdata) {
        //convert incoming JSON POST data into array(Object inside)
        //and then convert to pure array
        //*require function "convertArrObjToArray"

        $arrObj = json_decode(stripslashes($postdata));
        $arr = $this->convertArrObjToArray($arrObj);

        return $arr;
    }

    private function convertArrObjToArray($arrObj) {
        //Convert array(Object inside) to pure array
        //array(Object inside) is coming from JSON sending
        $array = array();

        //echo "test :: " . $data[0]->jobs_name . "\n";
        foreach ($arrObj as $objkey => $obj) {
            foreach ($obj as $key => $value) {
                $array[$objkey][$key] = $value;
            }
        }
        return $array;
    }

    function xhrInsert($arrData) {
        return $this->model->xhrInsert($arrData);
    }

    function xhrUpdateById($arrData) {
        return $this->model->xhrUpdateById($arrData);
    }

    function xhrDeleteById($parts_items_id) {
        return $this->model->xhrDeleteById($parts_items_id);
    }

    function xhrUpdateParts($store_id, $num, $event) {
        $this->loadModel('store');
        return $this->model->xhrUpdateParts($store_id, $num, $event);
    }

    function xhrInsertJobs($arrData) {
        $this->loadModel('jobs_items');
        return $this->model->xhrInsert($arrData);
    }

    function xhrUpdateJobs($arrData) {
        $this->loadModel('jobs_items');
        return $this->model->xhrUpdateById($arrData);
    }

    function xhrDeleteJobs($jobs_items_id) {
        $this->loadModel('jobs_items');
        return $this->model->xhrDeleteById($jobs_items_id);
    }

    function xhrUpdateState() {
        $this->model->xhrUpdateServiceStatus();
        //$this->model->xhrInsertServiceStatusDetail();
    }

//    function xhrDeleteById() {
//        $data = array('chk' => $this->model->xhrCheckUseById(), 'sta' => 'del');
//        if ($data['chk']) {
//            $this->model->xhrDeleteById();
//        }
//        echo json_encode($data);
//    }
    // public function getPartsItems() {
    public function getPartsItems() {
        //$this->loadModel('parts_items');
        return $this->model->xhrGetSelect();
    }

    function Pagination() {
        $this->model->Pagination();
    }

}
