<?php

class Jobs_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrGetSelect() {
        $subQuery .= (($_GET['search'] <> '') ? " and j.jobs_name like '%{$_GET['search']}%' " : '');
        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }

        $sql = "SELECT j.*, g.jobs_group_name
                FROM jobs j
                LEFT OUTER JOIN jobs_group g on g.jobs_group_id = j.jobs_group
                WHERE 1
                 {$subQuery} ORDER BY Sort asc {$limit}";

        $data = $this->db->select($sql);
        echo json_encode($data);
        // echo $sql;
    }

    /* =============================================
     * SQL : INSERT/UPDATE/DELETE
      ============================================== */

    public function insertDataByID() {
        $strsql = 'INSERT INTO jobs (jobs_name, jobs_unit_price, jobs_group,sort,jobs_status,hos_guid) '
                . 'SELECT :jobs_name, :jobs_unit_price, :jobs_group '
                . ',(SELECT max(sort)+1 FROM jobs WHERE jobs_group = :jobs_group) '
                . ',1'
                . ',concat("{",upper(uuid()),"}")';


        $sth = $this->db->prepare($strsql);
        $sth->execute(array(
            ':jobs_name' => $_POST['jobs_name'],
            ':jobs_unit_price' => $_POST['jobs_unit_price'],
            ':jobs_group' => $_POST['jobs_group'],
        ));
    }

    public function editDataByID() {
        $sth = $this->db->prepare('UPDATE jobs SET jobs_name = :jobs_name'
                . ',jobs_group= :jobs_group_id '
                . ',jobs_unit_price= :jobs_unit_price '
                . ',sort= :jobs_sort '
                . 'WHERE jobs_id = :jobs_id ');
        $sth->execute(array(
            ':jobs_id' => $_POST['jobs_id'],
            ':jobs_name' => $_POST['jobs_name'],
            ':jobs_group_id' => $_POST['jobs_group'],
            ':jobs_unit_price' => $_POST['jobs_unit_price'],
            ':jobs_sort' => $_POST['jobs_sort']
        ));

        $data = array('chk' => true, 'sta' => 'edit');
       echo json_encode($data);
    }

    function deleteDataByID() {
        $sth = $this->db->prepare('DELETE FROM jobs WHERE jobs_id = "' . $_POST['id'] . '" ');
        $sth->execute();
    }

    /* =============================================
     * SQL : get data by specific key
      ============================================== */

    function getDataByID() {
//        $data = $this->db->select('SELECT s.sym_id, s.sym_name, s.hardware_type_id, s.sym_sort 
//                                    FROM symptom s
//                                    WHERE s.sym_id = "' . $_POST['id'] . '" ');
        $data = $this->db->select('SELECT j.jobs_id, j.jobs_name, j.jobs_unit_price, j.jobs_group, j.sort,j.jobs_status, j.hos_guid, g.* 
                                    FROM jobs j
                                    LEFT OUTER JOIN jobs_group g on g.jobs_group_id = j.jobs_group
                                    WHERE j.jobs_id = :jobs_id ', array(':jobs_id' => $_POST['id']));
        echo json_encode($data);
    }

    function getDataByGroup() {
        $data = $this->db->select('SELECT j.jobs_id, j.jobs_name, j.jobs_unit_price, j.jobs_group, j.sort,j.jobs_status, j.hos_guid, g.* 
                                    FROM jobs j
                                    LEFT OUTER JOIN jobs_group g on g.jobs_group_id = j.jobs_group
                                    WHERE j.jobs_group = :jobs_group ', array(':jobs_group' => $_POST['id']));
        echo json_encode($data);
    }

    /* =============================================
     * SQL : check usable
      ============================================== */

    function checkDataUseByID() {
        $sth = $this->db->prepare("SELECT * FROM jobs_items WHERE jobs_id = '{$_POST['id']}'");
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /* =============================================
     * SQL : retrive all data
      ============================================== */

    public function jobsRs() {
        if ($_POST['jobs_group'] > 0) {
            $condition = " WHERE jobs_group = '{$_POST['jobs_group']}' ";
        } else {
            $condition = '';
        }

        $data = $this->db->select("SELECT * FROM jobs j LEFT OUTER JOIN jobs_group g on g.jobs_group_id = j.jobs_group " . $condition . " ORDER BY j.sort");
        // echo json_encode($data);
        return $data;
    }

    public function jobsGroupRs() {

        $data = $this->db->select("SELECT * FROM jobs_group " . $condition . " ORDER BY sort");
        return $data;
    }

    /* ================================================
     * SQL : retrive data for displaying + Pagination
      ================================================= */

    function getDataListings() {
        $condition = "";
        if ($_REQUEST['id'] === " ") {
            $id = '99';
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
        
        $condition = "WHERE jg.jobs_group_id = '" . $id . "' ";
        $sql = "SELECT j.jobs_id, j.jobs_name, j.jobs_unit_price, j.jobs_group, j.sort, 
            j.jobs_status, j.hos_guid, jg.jobs_group_name 
            FROM jobs j 
            LEFT OUTER JOIN jobs_group jg on jg.jobs_group_id =  j.jobs_group "
            . $condition .
            " ORDER BY j.jobs_name,j.sort " .$limit ;
        $data = $this->db->select($sql);
        echo json_encode($data);
    }

    public function Pagination() {
        //$subQuery = (($_POST['search'] <> '') ? " and j.jobs_name like '%{$_POST['search']}%' " : '');
        $condition = ($_REQUEST['jobs_group_id'] === " ")? " AND j.jobs_group = '99'":" AND j.jobs_group = '{$_REQUEST['jobs_group_id']}'";

        $sql = "SELECT j.jobs_id FROM jobs j WHERE 1 {$condition}";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));

        echo json_encode($data);
    }
    
    public function xhrCheckUseById() {
        $sth = $this->db->prepare("SELECT * FROM jobs_items WHERE jobs_id = '{$_POST['jobs_id']}'");
        $sth->execute();

        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

}
