<?php

//    make by Shikaru
class Hardware_type_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function hardwareTypeRs() {
        return $this->db->select('SELECT hardware_type_id,hardware_type_name,sort
                                    FROM hardware_type  
                                    ORDER BY sort ');
    }

    public function xhrInsert() {
        $sth = $this->db->prepare('INSERT INTO hardware_type (hardware_type_id,hardware_type_name,sort) VALUE (:hardware_type_id,:hardware_type_name,:sort)');
        if ($sth) {
            $data = array(
                'hardware_type_id' => $this->MaxId() + 1,
                'hardware_type_name' => $_POST['hardware_type_name'],
                'sort' => $this->MaxSort() + 1
            );
            $sth->execute($data);

            echo json_encode($data);
        }
    }

    public function xhrGetSelect() {
        $subquery = '';
        if(!empty($_GET["search"]))
        {
            $subquery = ' AND hardware_type_name LIKE "%'.$_GET["search"].'%" ';
        }
        $data = $this->db->select('SELECT * FROM hardware_type WHERE hardware_type_id <> "-1" '.$subquery.' ORDER BY sort');
        echo json_encode($data);
    }

    public function xhrSelectById() {
        $data = $this->db->select("SELECT * FROM hardware_type WHERE hardware_type_id = '{$_POST['hardware_type_id']}'");
        echo json_encode($data);
    }

    public function xhrUpdateById() {
        $sql = 'UPDATE hardware_type SET hardware_type_name = :hardware_type_name, sort = :sort WHERE hardware_type_id = :hardware_type_id ';
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':hardware_type_name' => $_POST['hardware_type_name'],
            ':sort' => $_POST['sort'],
            ':hardware_type_id' => $_POST['hardware_type_id']
        ));
        $data = array('chk' => true);
        echo json_encode($data);
    }

    public function xhrDeleteById() {
        $sth = $this->db->prepare("DELETE FROM hardware_type WHERE hardware_type_id = '{$_POST['hardware_type_id']}'");
        $sth->execute();
    }

    public function xhrCheckUseById() {
        $sth1 = $this->db->prepare("SELECT * FROM hardware WHERE hardware_type_id = '{$_POST['hardware_type_id']}'");
        $sth1->execute();

        $sth2 = $this->db->prepare("SELECT * FROM symptom WHERE hardware_type_id = '{$_POST['hardware_type_id']}'");
        $sth2->execute();

        if ($sth1->rowCount() > 0 || $sth2->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function MaxId() {
        $sth = $this->db->prepare("SELECT MAX(hardware_type_id) as hardware_type_id FROM hardware_type WHERE hardware_type_id <> '-1'");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['hardware_type_id'];
    }

    public function MaxSort() {
        $sth = $this->db->prepare("SELECT MAX(sort) as sort FROM hardware_type WHERE hardware_type_id <> '-1'");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['sort'];
    }

}
