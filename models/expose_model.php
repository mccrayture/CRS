<?php

//    make by Shikaru
class Expose_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrGetSelect() {
        $word = explode(' ', $_GET['search']);
        $subQuery .= (($_GET['depart_id'] > 0) ? " and i.depart_id = '{$_GET['depart_id']}' " : '');
        $subQuery .= (($_GET['hardware_id'] > 0) ? " and i.hardware_id = '{$_GET['hardware_id']}' " : '');
        if ($_GET['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(i.sn_scph,i.brand,i.model,i.serial_number,h.hardware_name,d.depart_name) like '%{$value}%' ";
            }
        }
        $subQuery = ($subQuery == '') ? ' and 0 ' : $subQuery;
        if($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = " limit {$_GET['perPage']} ";
        }
        
        $sql = "select i.items_id,i.sn_scph,i.serial_number,i.brand,i.model,i.buydate,i.expdate,h.hardware_id,h.hardware_name,d.depart_id,d.depart_name,
                if(i.expdate is not null,if(timestampdiff(day,date(now()),i.expdate) < 0,1,0),0) as expire
                from items i left outer join hardware h on h.hardware_id = i.hardware_id
                left outer join depart d on d.depart_id = i.depart_id
                where 1 {$subQuery} order by i.items_id desc {$limit}";
        $data = $this->db->select($sql);
        echo json_encode($data);
    }

    public function xhrSelectById() {
        $data = $this->db->select("select i.items_id,i.sn_scph,i.serial_number,i.brand,i.model,i.buydate,i.expdate,h.hardware_id,h.hardware_name,d.depart_id,d.depart_name,
                        if(i.expdate is not null,if(timestampdiff(day,date(now()),i.expdate) < 0,1,0),0) as expire
                        from items i
                        left outer join hardware h on h.hardware_id = i.hardware_id
                        left outer join depart d on d.depart_id = i.depart_id
                        where i.items_id = '{$_POST['items_id']}'");
        echo json_encode($data);
    }

    public function xhrInsert() {
        $sth = $this->db->prepare('INSERT INTO items (items_id, sn_scph, serial_number, hardware_id, brand, model, depart_id, buydate, expdate, lastupdate) '
                . ' VALUES (:items_id, :sn_scph, :serial_number, :hardware_id, :brand, :model, :depart_id, :buydate, :expdate, now())');
        if ($sth) {
            $data = array(
                'items_id' => $this->MaxId() + 1,
                'sn_scph' => $_POST['sn_scph'],
                'serial_number' => $_POST['serial_number'],
                'hardware_id' => $_POST['hardware_id'],
                'brand' => $_POST['brand'],
                'model' => $_POST['model'],
                'depart_id' => $_POST['depart_id'],
                'buydate' => $_POST['buydate'],
                'expdate' => $_POST['expdate']
            );
            $sth->execute($data);
            $data += array('sta' => 'add');

            echo json_encode($data);
        }
    }

    public function xhrUpdateById() {
        $sql = 'UPDATE items SET '
                . 'sn_scph = :sn_scph, '
                . 'serial_number = :serial_number, '
                . 'hardware_id = :hardware_id, '
                . 'brand = :brand, '
                . 'model = :model, '
                . 'depart_id = :depart_id, '
                . 'buydate = :buydate, '
                . 'expdate = :expdate, '
                . 'lastupdate = now() '
                . 'WHERE items_id = :items_id ';
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':sn_scph' => $_POST['sn_scph'],
            ':serial_number' => $_POST['serial_number'],
            ':hardware_id' => $_POST['hardware_id'],
            ':brand' => $_POST['brand'],
            ':model' => $_POST['model'],
            ':depart_id' => $_POST['depart_id'],
            ':buydate' => $_POST['buydate'],
            ':expdate' => $_POST['expdate'],
            ':items_id' => $_POST['items_id']
        ));
        $data = array('chk' => true, 'sta' => 'edit');
        echo json_encode($data);
    }

    public function xhrDeleteById() {
        $sth = $this->db->prepare("DELETE FROM items WHERE items_id = '{$_POST['items_id']}'");
        $sth->execute();
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
        $sth = $this->db->prepare("SELECT MAX(items_id) as items_id FROM items");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['items_id'];
    }

    public function Pagination() {
        $word = explode(' ', $_POST['search']);
        $subQuery .= (($_POST['depart_id'] > 0) ? " and i.depart_id = '{$_POST['depart_id']}' " : '');
        $subQuery .= (($_POST['hardware_id'] > 0) ? " and i.hardware_id = '{$_POST['hardware_id']}' " : '');
        if ($_POST['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(i.sn_scph,i.brand,i.model,i.serial_number,h.hardware_name,d.depart_name) like '%{$value}%' ";
            }
        }
        $subQuery = ($subQuery == '') ? ' and 0 ' : $subQuery;
        $sth = $this->db->prepare("select i.items_id
                from items i left outer join hardware h on h.hardware_id = i.hardware_id
                left outer join depart d on d.depart_id = i.depart_id
                where 1 {$subQuery} ");
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));
        echo json_encode($data);
    }
}