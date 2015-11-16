<?php

class Hardware_Model extends Model {

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
        $sql = 'SELECT h.hardware_id, h.hardware_name, ht.hardware_type_id, ht.hardware_type_name, h.hardware_group_id, h.hardware_sort 
                                    FROM hardware h
                                    LEFT OUTER JOIN hardware_type ht on ht.hardware_type_id =  h.hardware_type_id '
                . $condition .
                'ORDER BY h.hardware_name , h.hardware_sort ' .
                $limit;
        $data = $this->db->select($sql);
        echo json_encode($data);
    }

    public function insertDataByID() {
        $sth = $this->db->prepare('INSERT INTO hardware (hardware_name, hardware_type_id, hardware_group_id, hardware_sort) 
                                    SELECT :hardware_name,:hardware_type_id, :hardware_group_id, ( SELECT max(hardware_sort)+1 FROM hardware WHERE hardware_type_id =:hardware_type_id and hardware_sort <> "99") ');

        $sth->execute(array(
            ':hardware_name' => $_POST['hardware_name'],
            ':hardware_type_id' => $_POST['hardware_type_id'],
            ':hardware_group_id' => $_POST['hardware_group_id'],
            ':hardware_sort' => $_POST['hardware_sort']
        ));
    }

    public function editDataByID() {
        $sql = 'UPDATE hardware  SET hardware_name= :hardware_name, hardware_type_id= :hardware_type_id, hardware_group_id= :hardware_group_id, hardware_sort= :hardware_sort WHERE hardware_id= :hardware_id ';
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':hardware_id' => $_POST['hardware_id'],
            ':hardware_name' => $_POST['hardware_name'],
            ':hardware_type_id' => $_POST['hardware_type_id'],
            ':hardware_group_id' => $_POST['hardware_group_id'],
            ':hardware_sort' => $_POST['hardware_sort']
        ));
    }

    function deleteDataByID() {
        $sth = $this->db->prepare('DELETE FROM hardware WHERE hardware_id = "' . $_POST['id'] . '" ');
        $sth->execute();
    }

    function getDataByID() {
        $data = $this->db->select('SELECT h.hardware_id, h.hardware_name, h.hardware_type_id, h.hardware_group_id, h.hardware_sort 
                                    FROM hardware h
                                    WHERE h.hardware_id = "' . $_POST['id'] . '" ');
        echo json_encode($data);
    }

    function checkDataUseByID() {
        $sth = $this->db->prepare("SELECT * FROM items WHERE hardware_id = '{$_POST['id']}'");
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function hardwareRs() {
        if ($_POST['hardware_type_id'] > 0) {
            $condition = " WHERE ht.hardware_type_id = '{$_POST['hardware_type_id']}' ";
        }else{
            $condition = '';
        }
        return $this->db->select("select h.hardware_id,h.hardware_name,h.hardware_sort,ht.hardware_type_id,ht.hardware_type_name,ht.sort
                        from hardware h
                        left outer join hardware_type ht on ht.hardware_type_id = h.hardware_type_id
                        {$condition}
                        order by ht.sort,h.hardware_sort");
    }

    public function Pagination() {

        $condition = "";
        if ($_REQUEST['id'] === " ") {
            $id = '1';
        } else {
            $id = $_REQUEST['id'];
        }

        $condition = "WHERE ht.hardware_type_id = '" . $id . "' ";
        $sql = 'SELECT h.hardware_id, h.hardware_name, ht.hardware_type_id, ht.hardware_type_name, h.hardware_group_id, h.hardware_sort 
                                    FROM hardware h
                                    LEFT OUTER JOIN hardware_type ht on ht.hardware_type_id =  h.hardware_type_id '
                . $condition .
                'ORDER BY h.hardware_name , h.hardware_sort ';

        $sth = $this->db->prepare($sql);
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));

        echo json_encode($data);
    }

}
