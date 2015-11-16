<?php

//    make by Shikaru
class Service extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array('../public/bootstrap-datetimepicker/css/bootstrap-datepicker3.css',
            '../public/css/no-more-tables.css',
            'service/css/default.css'
        );
        $this->view->js = array('service/js/default.js',
            'service/js/Items.js',
            'service/js/Person.js',
            'service/js/Jobs_Parts.js',
//            'service/js/SerStates.js',
            'service/js/ThaiBaht.js',
            '../public/bootstrap-datetimepicker/js/bootstrap-datepicker.js',
            '../public/bootstrap-datetimepicker/locales/bootstrap-datepicker.th.min.js'
        );
    }

    function index() {
        $this->view->getServiceYear = $this->xhrSelectServiceYear();
        $this->view->getServiceCause = $this->xhrSelectServiceCause();
        $this->view->getDepart = $this->getDepart();
        $this->view->getServiceStatus = $this->getServiceStatus();
        $this->view->getServiceDetailStatus2 = $this->getServiceDetailStatus2();
        $this->view->getHardwareType = $this->getHardwareType();
        $this->view->storeTypeRs = $this->getStoreType();

        $this->view->getTechnicianList = $this->getTechnicianList();
 //         $this->view->getTechnician = $this->getTechnician();
//          $this->view->rander('service/index');

        $this->view->randerHeader();
        $this->view->randerContent('service/index');
        $this->view->randerContent('service/modal_State');
        $this->view->randerContent('service/preview');
//        $this->view->randerFooter();
    }

    function xhrGetSelect() {
        $data = $this->model->xhrGetSelect();
        for ($i = 0; $i < sizeof($data); $i++) {
            $valname = $this->getPersonNameById($data[$i]['service_technician']);
            $data[$i]['service_technician_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];
        }
        echo json_encode($data);
    }

    function xhrSelectById() {
        $data = $this->model->xhrSelectById();
        //แปลง cid เป็น ชื่อ 
        $valuser = $this->getPersonNameById($data[0]['service_user']);
        $data[0]['service_user_name'] = $valuser[0]['prefix'] . $valuser[0]['firstname'] . ' ' . $valuser[0]['lastname'];
        $valtech = $this->getPersonNameById($data[0]['service_technician']);
        $data[0]['service_technician_name'] = $valtech[0]['prefix'] . $valtech[0]['firstname'] . ' ' . $valtech[0]['lastname'];

        echo json_encode($data);
    }

    function xhrSelectServiceCause() {
        return $this->model->xhrSelectServiceCause();
    }

    function xhrSelectServiceYear() {
        return $this->model->xhrSelectServiceYear();
    }

    function xhrInsert($staff = null) {
        $this->model->xhrInsert($staff);
    }

    function xhrEditById($staff = null) {
        $this->model->xhrUpdateById($staff);
    }

    function xhrUpdServiceDetail() {
        $this->model->xhrUpdServiceDetail();
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

    public function getServiceDetailStatus2() {
        $this->loadModel('service_detail_status');
        return $this->model->xhrGetSelect();
    }

    public function getServiceDetailStatus() {
        $this->loadModel('service_detail_status');
        $data = $this->model->xhrGetSelect();
        echo json_encode($data);
//        return $this->model->xhrGetSelect();
    }

    public function getServiceDetailText() {
        $data = $this->model->getDetailTextById();
        echo json_encode($data);
    }

    public function getSymptom() {
        $this->loadModel('symptom');
        $data = $this->model->symptomRs();
        echo json_encode($data);
    }

    public function getServicePreview($service_id) {
        //รายการซ่อม 
        $data1 = $this->model->xhrSelectById($service_id);

        //ประวัติการซ่อม
        $data2 = $this->model->xhrGetServiceDetail($service_id);

        //รายการงานซ่อม
        $this->loadModel('jobs_items');
        $data3 = $this->model->xhrSelectByServiceId($service_id);

        //รายการอะไหล่ 
        $this->loadModel('parts_items');
        $data4 = $this->model->xhrSelectByServiceId($service_id);

        //แปลง cid เป็น ชื่อ 
        $valuser = $this->getPersonNameById($data1[0]['service_user']);
        $data1[0]['service_user_name'] = $valuser[0]['prefix'] . $valuser[0]['firstname'] . ' ' . $valuser[0]['lastname'];
        $valtech = $this->getPersonNameById($data1[0]['service_technician']);
        $data1[0]['service_technician_name'] = $valtech[0]['prefix'] . $valtech[0]['firstname'] . ' ' . $valtech[0]['lastname'];
        for ($i = 0; $i < sizeof($data2); $i++) {
            $valname = $this->getPersonNameById($data2[$i]['service_detail_user']);
            $data2[$i]['service_detail_user_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];
        }
        for ($i = 0; $i < sizeof($data3); $i++) {
            $valname = $this->getPersonNameById($data3[$i]['jobs_staff']);
            $data3[$i]['jobs_staff_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];
        }
        for ($i = 0; $i < sizeof($data4); $i++) {
            $valname = $this->getPersonNameById($data4[$i]['parts_staff']);
            $data4[$i]['parts_staff_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];
        }

        $preview = array('service' => $data1, 'service_detail' => $data2, 'jobs_items' => $data3, 'parts_items' => $data4);
//        var_dump($preview);exit();
        echo json_encode($preview);
    }

    public function getServiceDetail() {
        $data = $this->model->xhrGetServiceDetail();
        for ($i = 0; $i < sizeof($data); $i++) {
            $valname = $this->getPersonNameById($data[$i]['service_detail_user']);
            $data[$i]['service_detail_user_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];
        }
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

    public function getStore() {
        $this->loadModel('store');
        return $this->model->xhrGetSelectInStock();
    }

    public function getStoreType() {
        $this->loadModel('store_type');
        return $this->model->storeTypeRs();
    }

    public function getJobs() {
        $this->loadModel('jobs');
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

    //create by shikaru 28/08/2558
    public function getPersonNameById($person_id) {
        $this->loadModel('technician');
        return $this->model->getPersonNameById($person_id);
    }

    public function chkCoworker() {
        echo json_encode($this->model->CountCoworker());
    }

    public function delServiceDetail() {
        $this->model->deleteServiceDetail();
    }

    function Pagination($model = NULL) {
        if ($model) {
            $this->loadModel($model);
        }
        $this->model->Pagination();
    }

    //PDF
    //create by opol
    function pdfGen($service_id) {
        $data = $this->model->xhrSelectByIdForPDF($service_id);

        //รายการงานซ่อม
        $this->loadModel('jobs_items');
        $data2 = $this->model->xhrSelectByServiceIdForPDF($service_id);

        //รายการอะไหล่ 
        $this->loadModel('parts_items');
        $data3 = $this->model->xhrSelectByServiceIdForPDF($service_id);

        #service_technician
        $valname = $this->getPersonNameById($data[0]['service_technician']);
        $data[0]['service_technician_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];

        #service_user
        $valuser = $this->getPersonNameById($data[0]['service_user']);
        $data[0]['service_user_name'] = $valuser[0]['prefix'] . $valuser[0]['firstname'] . ' ' . $valuser[0]['lastname'];

        for ($i = 0; $i < sizeof($data2); $i++) {
            $valjobs = $this->getPersonNameById($data2[$i]['jobs_staff']);
            $data2[$i]['jobs_staff_name'] = $valjobs[0]['prefix'] . $valjobs[0]['firstname'] . ' ' . $valjobs[0]['lastname'];
        }

        for ($i = 0; $i < sizeof($data3); $i++) {
            $valparts = $this->getPersonNameById($data3[$i]['parts_staff']);
            $data3[$i]['parts_staff_name'] = $valparts[0]['prefix'] . $valparts[0]['firstname'] . ' ' . $valparts[0]['lastname'];
        }

        $this->view->pdfGen = $data;
        $this->view->pdfJobs = array($data2);
        $this->view->pdfParts = array($data3);
        #echo json_encode($data);
        #echo json_encode($data2);
        #echo json_encode($data3);
        #service_technician
//        $valname = $this->getPersonNameById($data[0]['service_technician']);
//        $data[0]['service_technician_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];

        $this->view->randerContent('service/pdf_CRS');
    }

    //create by bossrover 8/9/2558
    public function getTechnicianList() {
        $this->loadModel('technician');
        return $this->model->getDataListings();
    }

}
