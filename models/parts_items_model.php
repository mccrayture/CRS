<?php

//    make by Komsan 13/07/2558
class Parts_items_Model extends Model {

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

        $sql = "SELECT i.*, s.store_lotno, s.store_name, s.serial_number, s.store_unit_price, (i.parts_qty * s.store_unit_price) as store_sum_price, st.store_type_name, st.store_type_keeping, st.store_type_count, s.store_adddate,
                (SELECT store_stock from store where store.store_id = i.store_id) as stock    
                FROM parts_items i
                LEFT OUTER JOIN store s on s.store_id = i.store_id
                LEFT OUTER JOIN store_type st on st.store_type_id = s.store_type_id
                WHERE 1
                 {$subQuery} ORDER BY parts_items_id asc {$limit}";


        return $this->db->select($sql);
//        $data = $this->db->select($sql);
//        echo json_encode($data);
    }

    public function xhrSelectById() {
        $data = $this->db->select("select i.items_id,i.sn_scph,i.serial_number,i.brand,i.model,i.ipaddress,i.items_name,i.buydate,i.expdate,h.hardware_id,h.hardware_name,d.depart_id,d.depart_name,
                        if(i.expdate is not null,if(timestampdiff(day,date(now()),i.expdate) < 0,1,0),0) as expire
                        from items i
                        left outer join hardware h on h.hardware_id = i.hardware_id
                        left outer join depart d on d.depart_id = i.depart_id
                        where i.items_id = '{$_POST['items_id']}'");
        echo json_encode($data);
    }

	public function xhrSelectByServiceId($service_id = null) {
        $service_id = (is_null($service_id)) ? $_POST['service_id'] : $service_id;
        return $this->db->select("SELECT i.*, s.store_lotno, s.store_name, s.serial_number, s.store_unit_price, (i.parts_qty * s.store_unit_price) as store_sum_price, st.store_type_name, st.store_type_count
                        FROM parts_items i
                        LEFT OUTER JOIN store s on s.store_id = i.store_id
                        LEFT OUTER JOIN store_type st on st.store_type_id = s.store_type_id
                        WHERE i.service_id = '{$service_id}'");
    }
	
    public function xhrSelectByServiceIdForPDF($id = null) {
        $id = (is_null($id)) ? $_POST['service_id'] : $id;
		//SQL for PDF
        $sql = "SELECT DATE_FORMAT(i.parts_date,'%d-%m-%Y') as parts_date, i.parts_items_id,i.service_id,i.store_id,i.parts_qty,i.parts_datetime,i.parts_staff,i.parts_modified,i.hos_guid, 
					s.store_lotno, s.store_name, s.serial_number, s.store_unit_price, (i.parts_qty * s.store_unit_price) as store_sum_price, st.store_type_name, st.store_type_count
                        FROM parts_items i
                        LEFT OUTER JOIN store s on s.store_id = i.store_id
                        LEFT OUTER JOIN store_type st on st.store_type_id = s.store_type_id
                        WHERE i.service_id = '{$id}'";
		 return $this->db->select($sql);
    }

    public function xhrInsert($arr) {

        $sth = $this->db->prepare('INSERT INTO parts_items (service_id, store_id, parts_unit_price, parts_qty, parts_sum_price, parts_date, parts_datetime, parts_staff, hos_guid) '
                . ' VALUES (:service_id, :store_id, :parts_unit_price, :parts_qty, :parts_sum_price, :parts_date, now(), :parts_staff, concat("{",upper(uuid()),"}")) ');
        if ($sth) {
            $data = array(
                'service_id' => $arr['service_id'],
                'store_id' => $arr['store_id'],
                'parts_unit_price' => $arr['parts_unit_price'],
                'parts_qty' => $arr['parts_qty'],
                'parts_sum_price' => $arr['parts_sum_price'],
                'parts_date' => $arr['parts_date'],
                'parts_staff' => $arr['parts_staff']
            );

            if ($sth->execute($data)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function xhrUpdateById($arr) {
        $sql = 'UPDATE parts_items SET service_id = :service_id, store_id = :store_id, '
                .' parts_unit_price = :parts_unit_price, parts_qty = :parts_qty, parts_sum_price = :parts_sum_price, '
                .' parts_date = :parts_date, parts_modified = :parts_modified '
                .' WHERE parts_items_id = :parts_items_id ';
        $sth = $this->db->prepare($sql);

        if ($sth) {
            $data = array(
                'parts_items_id' => $arr['parts_items_id'],
                'service_id' => $arr['service_id'],
                'store_id' => $arr['store_id'],
                'parts_unit_price' => $arr['parts_unit_price'],
                'parts_qty' => $arr['parts_qty'],
                'parts_sum_price' => $arr['parts_sum_price'],
                'parts_date' => $arr['parts_date'],
                'parts_modified' => $arr['parts_modified']
            );
            if ($sth->execute($data)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function xhrDeleteById($parts_items_id) {
        $sth = $this->db->prepare("DELETE FROM parts_items WHERE parts_items_id = '{$parts_items_id}' ");

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
        $sth = $this->db->prepare("SELECT MAX(parts_items_id) as parts_items_id FROM part_items");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['parts_items_id'];
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
