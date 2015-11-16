<?php

//    make by Shikaru
class Store_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrGetSelect() {        
        //SQL_NO_CACHE 
        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }
        /*
        $data = $this->db->select("(SELECT s.*, st.store_type_name, st.store_type_keeping, st.store_type_count, s.hos_guid 
                        FROM store s 
                        LEFT OUTER JOIN store_type st ON st.store_type_id = s.store_type_id 
                        WHERE s.store_type_id = '{$_GET['store_type_id']}' 
                        AND s.store_closedate is null
                        ORDER BY s.store_id DESC
                        )
                        union all
                        (
                        SELECT s.*, st.store_type_name, st.store_type_keeping, st.store_type_count, s.hos_guid
                        FROM store s 
                        LEFT OUTER JOIN store_type st ON st.store_type_id = s.store_type_id 
                        WHERE s.store_type_id = '{$_GET['store_type_id']}' 
                        AND s.store_closedate is not null
                        ORDER BY s.store_closedate DESC
                        LIMIT 5)");
                        */
        $data = $this->db->select("SELECT s.*, st.store_type_name, st.store_type_keeping, st.store_type_count, s.hos_guid 
                        FROM store s 
                        LEFT OUTER JOIN store_type st ON st.store_type_id = s.store_type_id 
                        WHERE s.store_type_id = '{$_GET['store_type_id']}' 
                        ORDER BY s.store_closedate ASC, s.store_id DESC {$limit} "
                        );
        echo json_encode($data);
    }

    public function xhrGetSelectInStock() {
        $subQuery = (($_GET['store_type_id'] == '') ? '' : " and st.store_type_id = '{$_GET['store_type_id']}' ");
        $word = explode(' ', $_GET['search']);
        if ($_GET['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(st.store_type_name,s.store_name,s.serial_number,s.store_lotno) like '%{$value}%' ";
            }
        }
        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " LIMIT {$_GET['perPage']} " : '';
        }

        $sql = "SELECT s.*, st.store_type_name, st.store_type_keeping, st.store_type_count, (s.store_stock * s.store_unit_price) as store_sum_price, s.hos_guid
                        FROM store s 
                        LEFT OUTER JOIN store_type st ON st.store_type_id = s.store_type_id 
                        WHERE 1 {$subQuery}
                        AND s.store_closedate is null
                        ORDER BY s.store_adddate DESC {$limit}";

        $data = $this->db->select($sql);
        echo json_encode($data);
    }

    public function xhrSelectById() {
        $data = $this->db->select("SELECT s.*,st.store_type_name,st.store_type_keeping,st.store_type_count FROM store s LEFT OUTER JOIN store_type st ON st.store_type_id = s.store_type_id WHERE s.store_id = '{$_POST['store_id']}'");
        echo json_encode($data);
    }

    public function xhrInsert() {
        $sth = $this->db->prepare('INSERT INTO store (store_id, store_lotno, store_type_id, store_name, serial_number, store_unit_price, store_stock, store_max_count, store_adddate, store_staff, store_lastupdate) '
                . 'VALUE (:store_id, :store_lotno, :store_type_id, :store_name, :serial_number, :store_unit_price, :store_stock, :store_max_count, :store_adddate, :store_staff, now())');
        if ($sth) {
            $data = array(
                'store_id' => $this->MaxId() + 1,
                'store_lotno' => $_POST['store_lotno'],
                'store_type_id' => $_POST['store_type_id'],
                'store_name' => $_POST['store_name'],
                'serial_number' => $_POST['serial_number'],
                'store_unit_price' => $_POST['store_unit_price'],
                ':store_stock' => ($_POST['store_type_keeping'] !== 'serial') ? $_POST['store_stock'] : '1',
                'store_max_count' => $_POST['store_max_count'],
                'store_staff' => $_POST['userPerson_id'],
                'store_adddate' => $_POST['store_adddate']
            );
            $sth->execute($data);
            echo json_encode($data);
        }
    }

    public function xhrUpdateById() {
        $store_closedate = ' ';
        if ($_POST['store_type_keeping'] !== 'serial') {
            $store_closedate = 'store_closedate = if(store_stock > 0, NULL, now()),  ';
        } else {
            
        }

        $sql = 'UPDATE store SET '
                . 'store_lotno = :store_lotno, '
                . 'store_type_id = :store_type_id, '
                . 'store_name = :store_name, '
                . 'serial_number = :serial_number, '
                . 'store_unit_price = :store_unit_price, '
                . 'store_max_count = :store_max_count, '
                . 'store_stock = :store_stock, '
                . 'store_adddate = :store_adddate, '
                . $store_closedate
                . 'store_lastupdate = now() '
                . 'WHERE store_id = :store_id ';
        $sth = $this->db->prepare($sql);
        echo $sql;

        $sth->execute(array(
            ':store_lotno' => $_POST['store_lotno'],
            ':store_type_id' => $_POST['store_type_id'],
            ':store_name' => $_POST['store_name'],
            ':serial_number' => $_POST['serial_number'],
            ':store_unit_price' => $_POST['store_unit_price'],
            ':store_stock' => ($_POST['store_type_keeping'] !== 'serial') ? $_POST['store_stock'] : '1',
            ':store_max_count' => $_POST['store_max_count'],
            ':store_adddate' => $_POST['store_adddate'],
            ':store_id' => $_POST['store_id']
                //$_POST['store_stock']
        ));
        $data = array('chk' => true);
        echo json_encode($data);
    }

    public function xhrDeleteById() {
        $sth = $this->db->prepare("DELETE FROM store WHERE store_id = '{$_POST['store_id']}'");
        $sth->execute();
    }

    public function xhrUpdateParts($store_id, $num, $event) {
        if ($event === 'add') {
            $sql = 'UPDATE store SET '
                    . ' store_stock =  if ((store_stock + :num) > store_max_count, store_max_count,  (store_stock + :num) )  ,'
                    . 'store_closedate = if(store_stock > 0,NULL , now())'
                    . 'WHERE store_id = :store_id ';
        } else if ($event === 'sub') {
            $sql = 'UPDATE store SET '
                    . 'store_stock = (store_stock - :num) , '
                    . 'store_closedate = if(store_stock = 0, now(), NULL)'
                    . 'WHERE store_id = :store_id ';
        }

        $sth = $this->db->prepare($sql);

        if ($sth) {
            $data = array(
                ':num' => $num,
                ':store_id' => $store_id
            );
            if ($sth->execute($data)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function xhrCheckUseById() {
        $sth = $this->db->prepare("SELECT * FROM expose_detail WHERE store_id = '{$_POST['store_id']}'");
        $sth->execute();

        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function MaxId() {
        $sth = $this->db->prepare("SELECT MAX(store_id) as store_id FROM store");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['store_id'];
    }

    public function storeRs() {
        return $this->db->select('select s.store_id,s.store_lotno,s.store_type_id,st.store_type_name,st.store_type_keeping,st.store_type_count,s.store_name,s.serial_number,s.store_unit_price,s.store_max_count,s.store_adddate,s.store_closedate,s.hos_guid
                from store s 
                left outer join store_type st on st.store_type_id = s.store_type_id 
                order by st.store_type_sort,s.store_id desc');
    }

    public function Pagination() {
        $subQuery = (($_POST['store_type_id'] == '' || $_POST['store_type_id'] == 0) ? '' : " and st.store_type_id = '{$_POST['store_type_id']}' ");
        /*$word = explode(' ', $_POST['search']);
        if ($_POST['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(st.store_type_name,s.store_name,s.serial_number,s.store_lotno) like '%{$value}%' ";
            }
        }*/

        $sql = "SELECT s.*, st.store_type_name, st.store_type_keeping, st.store_type_count, (s.store_stock * s.store_unit_price) as store_sum_price, s.hos_guid
                        FROM store s 
                        LEFT OUTER JOIN store_type st ON st.store_type_id = s.store_type_id 
                        WHERE 1 {$subQuery}
                        AND s.store_closedate is null";

        $sth = $this->db->prepare($sql);
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));

        echo json_encode($data);
    }

}
