<?php

//    make by Komsan 13/07/2558
class Jobs_items_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrGetSelect() {
        $subQuery .= (($_GET['service_id'] > 0) ? " and i.service_id = '{$_GET['service_id']}' " : '');

        $subQuery = ($subQuery == '') ? ' and 0 ' : $subQuery;
        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }

        $sql = "SELECT i.*, j.jobs_name
                FROM jobs_items i
                LEFT OUTER JOIN jobs j on j.jobs_id = i.jobs_id
                WHERE 1
                 {$subQuery} ORDER BY jobs_items_id asc {$limit}";

        return $this->db->select($sql);
//        $data = $this->db->select($sql);
//        echo json_encode($data);
    }

    public function xhrSelectById($items_id = null) {
        $items_id = (is_null($items_id)) ? $_POST['items_id'] : $items_id;
        return $this->db->select("select i.items_id,i.sn_scph,i.serial_number,i.brand,i.model,i.ipaddress,i.items_name,i.buydate,i.expdate,h.hardware_id,h.hardware_name,d.depart_id,d.depart_name,
                        if(i.expdate is not null,if(timestampdiff(day,date(now()),i.expdate) < 0,1,0),0) as expire
                        from items i
                        left outer join hardware h on h.hardware_id = i.hardware_id
                        left outer join depart d on d.depart_id = i.depart_id
                        where i.items_id = '{$_POST['items_id']}'");
    }

    public function xhrSelectByServiceId($service_id = null) {
        $service_id = (is_null($service_id)) ? $_POST['service_id'] : $service_id;
        return $this->db->select("SELECT i.*, j.jobs_name
                        FROM jobs_items i
                        LEFT OUTER JOIN jobs j on j.jobs_id = i.jobs_id
                        WHERE i.service_id = '{$service_id}'");
    }
	
	public function xhrSelectByServiceIdForPDF($id = null) {
        $id = (is_null($id)) ? $_POST['service_id'] : $id;
        //SQL for PDF
		$sql = "SELECT DATE_FORMAT(i.jobs_date,'%d-%m-%Y') as jobs_date, i.jobs_items_id, i.service_id, i.jobs_id,
					i.jobs_unit_price, i.jobs_qty, i.jobs_sum_price, i.jobs_datetime, i.jobs_staff, i.jobs_modified, j.jobs_name
                        FROM jobs_items i
                        LEFT OUTER JOIN jobs j on j.jobs_id = i.jobs_id
                        WHERE i.service_id = '{$id}'";
		return $this->db->select($sql);
		#$data = $this->db->select($sql);
        #echo json_encode($data);
    }

    public function xhrInsert($arr) {
        $sth = $this->db->prepare('INSERT INTO jobs_items (jobs_items_id, service_id, jobs_id, jobs_unit_price, jobs_qty, jobs_sum_price, jobs_date, jobs_datetime, jobs_staff, jobs_modified, hos_guid_jobs, hos_guid) '
                . ' VALUES (:jobs_items_id, :service_id, :jobs_id, :jobs_unit_price, :jobs_qty, :jobs_sum_price, :jobs_date, NOW(), :jobs_staff, :jobs_modified, :hos_guid_jobs, concat("{",upper(uuid()),"}") )');
        if ($sth) {
            $data = array(
                'jobs_items_id' => $this->MaxId() + 1,
                'service_id' => $arr['service_id'],
                'jobs_id' => $arr['jobs_id'],
                'jobs_unit_price' => $arr['jobs_unit_price'],
                'jobs_qty' => $arr['jobs_qty'],
                'jobs_sum_price' => $arr['jobs_sum_price'],
                'jobs_date' => $arr['jobs_date'],
                'jobs_staff' => $arr['jobs_staff'],
                'jobs_modified' => $arr['jobs_modified'],
                'hos_guid_jobs' => $arr['hos_guid_jobs']
                    //'hos_guid' => $arr['hos_guid']
            );

             if ($sth->execute($data)) {
                return true;
            } else {
                return false;
            }
            
        }
    }

    public function xhrUpdateById($arr) {
        $sql = 'UPDATE jobs_items SET jobs_id = :jobs_id, jobs_unit_price = :jobs_unit_price, jobs_qty = :jobs_qty, '
                . ' jobs_sum_price = :jobs_sum_price, jobs_date = :jobs_date, jobs_modified = :jobs_modified  '
                . 'WHERE jobs_items_id = :jobs_items_id ';
        $sth = $this->db->prepare($sql);

        if ($sth) {
            $data = array(
                'jobs_items_id' => $arr['jobs_items_id'],
                'jobs_id' => $arr['jobs_id'],
                'jobs_unit_price' => $arr['jobs_unit_price'],
                'jobs_qty' => $arr['jobs_qty'],
                'jobs_sum_price' => $arr['jobs_sum_price'],
                'jobs_date' => $arr['jobs_date'],
                'jobs_modified' => $arr['jobs_modified']
            );

             if ($sth->execute($data)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function xhrDeleteById($jobs_items_id) {
        $sth = $this->db->prepare("DELETE FROM jobs_items WHERE jobs_items_id = '{$jobs_items_id}'");
        
         if ($sth->execute()) {
                return true;
            } else {
                return false;
            }
            
    }

    public function xhrCheckUseById() {
        $sth = $this->db->prepare("SELECT * FROM service WHERE items_id = '{$_POST['items_id']}'");
        $sth->execute();

        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function MaxId() {
        $sth = $this->db->prepare("SELECT MAX(jobs_items_id) as jobs_items_id FROM jobs_items");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['jobs_items_id'];
    }

    public function Pagination() {

        $condition = "";
        if ($_REQUEST['id'] === " ") {
            $id = '1';
        } else {
            $id = $_REQUEST['id'];
        }

        $condition = "WHERE i.service_id = '" . $id . "' ";
        $sql = 'SELECT i.*, s.store_lotno, s.store_name,s.serial_number, s.store_unit_price, st.store_type_name
                FROM parts_items i
                LEFT OUTER JOIN store s on s.store_id = i.store_id
                LEFT OUTER JOIN store_type st on st.store_type_id = s.store_type_id '
                . $condition .
                'ORDER BY parts_items_id desc ';

        $sth = $this->db->prepare($sql);
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));

        echo json_encode($data);
        //echo $sql;
    }

}
