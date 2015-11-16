<?php

//    make by Shikaru 
class Service_detail_status_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrGetSelect() {
        return $this->db->select('SELECT * FROM service_detail_status ORDER BY sort');
    }

    public function xhrSelectById() {
        $data = $this->db->select("SELECT * FROM service_detail_status WHERE status_id = '{$_POST['status_id']}'");
        echo json_encode($data);
    }

    public function xhrInsert() {
        $sth = $this->db->prepare('INSERT INTO service_detail_status (status_id,status_name,status_color,sort,allow_coworker) VALUE (:status_id,:status_name,:status_color,:sort,:allow_coworker)');
        if ($sth) {
            $data = array(
                'status_id' => $this->MaxId() + 1,
                'status_name' => $_POST['status_name'],
                'status_color' => $_POST['status_color'],
                'sort' => $this->MaxSort() + 1,
                'allow_coworker' => 'N',
                
            );
            $sth->execute($data);

            echo json_encode($data);
        }
    }

    public function xhrUpdateById() {
        $sql = 'UPDATE service_detail_status SET status_name = :status_name, status_color = :status_color, sort = :sort WHERE status_id = :status_id ';
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':status_name' => $_POST['status_name'],
            ':status_color' => $_POST['status_color'],
            ':sort' => $_POST['sort'],
            ':status_id' => $_POST['status_id']
        ));
        $data = array('chk' => true);
        echo json_encode($data);
    }

    public function xhrDeleteById() {
        $sth = $this->db->prepare("DELETE FROM service_detail_status WHERE status_id = '{$_POST['status_id']}'");
        $sth->execute();
    }

    public function xhrCheckUseById() {
        $sth1 = $this->db->prepare("SELECT * FROM service WHERE service_detail_status_id = '{$_POST['status_id']}' LIMIT 1");
        $sth1->execute();

//        $sth2 = $this->db->prepare("SELECT * FROM service WHERE service_status_id = '{$_POST['service_status_id']}' LIMIT 1");
//        $sth2->execute();
//
//        if ($sth1->rowCount() > 0 || $sth2->rowCount() > 0) {
//            return false;
//        } else {
//            return true;
//        }

        if ($sth1->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function MaxId() {
        $sth = $this->db->prepare("SELECT MAX(status_id) as status_id FROM service_detail_status");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['status_id'];
    }

    public function MaxSort() {
        $sth = $this->db->prepare("SELECT MAX(sort) as sort FROM service_detail_status");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['sort'];
    }

}
