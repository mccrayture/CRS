<?php

//    make by Shikaru 
class Service_status_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrGetSelect() {
        $data = $this->db->select('SELECT * FROM service_status ORDER BY sort');
        echo json_encode($data);
    }

    public function xhrSelectById() {
        $data = $this->db->select("SELECT * FROM service_status WHERE service_status_id = '{$_POST['service_status_id']}'");
        echo json_encode($data);
    }

    public function xhrInsert() {
        $sth = $this->db->prepare('INSERT INTO service_status (service_status_id,service_status_name,sort) VALUE (:service_status_id,:service_status_name,:sort)');
        if ($sth) {
            $data = array(
                'service_status_id' => $this->MaxId() + 1,
                'service_status_name' => $_POST['service_status_name'],
                'sort' => $this->MaxSort() + 1
            );
            $sth->execute($data);

            echo json_encode($data);
        }
    }

    public function xhrUpdateById() {
        $sql = 'UPDATE service_status SET service_status_name = :service_status_name, sort = :sort WHERE service_status_id = :service_status_id ';
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':service_status_name' => $_POST['service_status_name'],
            ':sort' => $_POST['sort'],
            ':service_status_id' => $_POST['service_status_id']
        ));
        $data = array('chk' => true);
        echo json_encode($data);
    }

    public function xhrDeleteById() {
        $sth = $this->db->prepare("DELETE FROM service_status WHERE service_status_id = '{$_POST['service_status_id']}'");
        $sth->execute();
    }

    public function xhrCheckUseById() {
        $sth1 = $this->db->prepare("SELECT * FROM service_detail WHERE service_status_id = '{$_POST['service_status_id']}' LIMIT 1");
        $sth1->execute();

        $sth2 = $this->db->prepare("SELECT * FROM service WHERE service_status_id = '{$_POST['service_status_id']}' LIMIT 1");
        $sth2->execute();

        if ($sth1->rowCount() > 0 || $sth2->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function serviceStatusRs() {
        return $this->db->select('SELECT * FROM service_status ORDER BY sort');
    }

    public function MaxId() {
        $sth = $this->db->prepare("SELECT MAX(service_status_id) as service_status_id FROM service_status");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['service_status_id'];
    }

    public function MaxSort() {
        $sth = $this->db->prepare("SELECT MAX(sort) as sort FROM service_status");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['sort'];
    }

}
