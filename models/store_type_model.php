<?php

//    make by Shikaru
class Store_type_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrGetSelect() {
        $data = $this->db->select('SELECT * FROM store_type ORDER BY store_type_name');
        echo json_encode($data);
    }

    public function xhrSelectById() {
        $data = $this->db->select("SELECT * FROM store_type WHERE store_type_id = '{$_POST['store_type_id']}'");
        echo json_encode($data);
    }

    public function xhrInsert() {
        $sth = $this->db->prepare('INSERT INTO store_type (store_type_id,store_type_name,store_type_keeping,store_type_count,store_type_sort) VALUE (:store_type_id,:store_type_name,:store_type_keeping,:store_type_count,:store_type_sort)');
        if ($sth) {
            $data = array(
                'store_type_id' => $this->MaxId() + 1,
                'store_type_name' => $_POST['store_type_name'],
                'store_type_keeping' => $_POST['store_type_keeping'],
                'store_type_count' => $_POST['store_type_count'],
                'store_type_sort' => $this->MaxSort() + 1
            );
            $sth->execute($data);

            echo json_encode($data);
        }
    }

    public function xhrUpdateById() {
        $sql = 'UPDATE store_type SET store_type_name = :store_type_name, store_type_keeping = :store_type_keeping, store_type_count = :store_type_count, store_type_sort = :store_type_sort WHERE store_type_id = :store_type_id ';
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':store_type_name' => $_POST['store_type_name'],
            ':store_type_keeping' => $_POST['store_type_keeping'],
            ':store_type_count' => $_POST['store_type_count'],
            ':store_type_sort' => $_POST['store_type_sort'],
            ':store_type_id' => $_POST['store_type_id']
        ));
        $data = array('chk' => true);
        echo json_encode($data);
    }

    public function xhrDeleteById() {
        $sth = $this->db->prepare("DELETE FROM store_type WHERE store_type_id = '{$_POST['store_type_id']}'");
        $sth->execute();
    }

    public function xhrCheckUseById() {
        $sth = $this->db->prepare("SELECT * FROM store WHERE store_type_id = '{$_POST['store_type_id']}'");
        $sth->execute();

        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function MaxId() {
        $sth = $this->db->prepare("SELECT MAX(store_type_id) as store_type_id FROM store_type");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['store_type_id'];
    }

    public function MaxSort() {
        $sth = $this->db->prepare("SELECT MAX(store_type_sort) as store_type_sort FROM store_type");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['store_type_sort'];
    }
    

    public function storeTypeRs() {
        return $this->db->select('SELECT store_type_id,store_type_name,store_type_keeping,store_type_count,store_type_sort FROM store_type ORDER BY store_type_sort');
    }

   
}
