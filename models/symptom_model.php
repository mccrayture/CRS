<?php

class Symptom_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function getDataListings() {
        $condition = "";
        if ($_REQUEST['id'] === " ") {
            $id = '1';
        } else {
            $id = $_REQUEST['id'];
        }
        /* ========= LIMIT ======== */
        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }
        /* ======================= */

        $condition = "WHERE ht.hardware_type_id = '" . $id . "' ";
        $sql = 'SELECT s.sym_id, s.sym_name, ht.hardware_type_id, ht.hardware_type_name, s.sym_sort 
                                    FROM symptom s
                                    LEFT OUTER JOIN hardware_type ht on ht.hardware_type_id =  s.hardware_type_id '
                . $condition .
                'ORDER BY ht.sort , s.sym_sort ' .
                $limit;
        $data = $this->db->select($sql);
        echo json_encode($data);
    }

    public function insertDataByID() {
        $sth = $this->db->prepare('INSERT INTO symptom (sym_name, hardware_type_id, sym_sort) 
                                    SELECT :sym_name,:hardware_type_id, ( SELECT max(sym_sort)+1 FROM symptom WHERE hardware_type_id =:hardware_type_id and sym_sort <> "99") ');

        $sth->execute(array(
            ':sym_name' => $_POST['sym_name'],
            ':hardware_type_id' => $_POST['hardware_type_id'],
            ':sym_sort' => $_POST['sym_sort']
        ));
    }

    public function editDataByID() {
        $sql = 'UPDATE symptom  SET sym_name = :sym_name, hardware_type_id= :hardware_type_id, sym_sort= :sym_sort WHERE sym_id = :sym_id ';
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':sym_id' => $_POST['sym_id'],
            ':sym_name' => $_POST['sym_name'],
            ':hardware_type_id' => $_POST['hardware_type_id'],
            ':sym_sort' => $_POST['sym_sort']
        ));
    }

    function deleteDataByID() {
        $sth = $this->db->prepare('DELETE FROM symptom WHERE sym_id = "' . $_POST['id'] . '" ');
        $sth->execute();
    }

    function getDataByID() {
//        $data = $this->db->select('SELECT s.sym_id, s.sym_name, s.hardware_type_id, s.sym_sort 
//                                    FROM symptom s
//                                    WHERE s.sym_id = "' . $_POST['id'] . '" ');
        $data = $this->db->select('SELECT s.sym_id, s.sym_name, s.hardware_type_id, s.sym_sort 
                                    FROM symptom s
                                    WHERE s.sym_id = :sym_id ', array(':sym_id' => $_POST['id']));
        echo json_encode($data);
    }

    function checkDataUseByID() {
        $sth = $this->db->prepare("SELECT * FROM service WHERE service_symptom = '{$_POST['id']}'");
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function symptomRs() {
        if ($_POST['hardware_type_id'] > 0) {
            $condition = " WHERE hardware_type_id = '{$_POST['hardware_type_id']}' ";
        } else {
            $condition = '';
        }
        
        /*return $this->db->select("SELECT * FROM symptom " . $condition . " ORDER BY sym_sort");
        */
        $data = $this->db->select("SELECT * FROM symptom " . $condition . " ORDER BY sym_sort");
      // echo json_encode($data);
        return $data;
    }

    public function Pagination() {

        $condition = "";
        if ($_REQUEST['id'] === " ") {
            $id = '1';
        } else {
            $id = $_REQUEST['id'];
        }

        $condition = "WHERE ht.hardware_type_id = '" . $id . "' ";
        $sql = 'SELECT s.sym_id, s.sym_name, ht.hardware_type_id, ht.hardware_type_name, s.sym_sort 
                                    FROM symptom s
                                    LEFT OUTER JOIN hardware_type ht on ht.hardware_type_id =  s.hardware_type_id '
                . $condition;

        $sth = $this->db->prepare($sql);
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));

        echo json_encode($data);
    }

}
