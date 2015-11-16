<?php

//    make by Shikaru
class Service_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrGetSelect() {
        $logged = Session::get('User');
//        $subQuery .= (($_GET['depart_id'] > 0) ? " and i.depart_id = '{$_GET['depart_id']}' " : '');
//        $subQuery .= (($_GET['hardware_id'] > 0) ? " and i.hardware_id = '{$_GET['hardware_id']}' " : '');
        $subQuery .= (($logged['type'] == 'staff') ? '' : " and (d.office_sit = '{$logged['ward_id']}' or s.service_user = '{$logged['person_id']}') and s.service_detail_status_id <> '0' ");
        $word = explode(' ', $_GET['search']);
        if ($_GET['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(concat(p.person_firstname,' ',p.person_lastname),concat(s.service_year,'/',s.service_no),i.sn_scph,i.brand,i.model,i.items_name,i.ipaddress,i.serial_number,h.hardware_name,d.depart_name) like '%{$value}%' ";
            }
        }
        if ($_GET['statusDetail']) {
            $i = 0;
            $detailList = $_GET['statusDetail'];
            $subQuery .= " AND ";
            $subQuery .= " s.service_detail_status_id in ( ";
            foreach ($detailList as $value) {
                $i++;
                IF ($i > 1) {
                    $subQuery .= " , ";
                }

                $subQuery .= " '" . $value . "' ";
            }
            $subQuery .= ") ";
        }
//        $subQuery = ($subQuery == '') ? ' and 0 ' : $subQuery;
        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }

        $sql = "select s.service_id, s.service_no, s.service_regdate,s.service_regdate,s.service_year,s.service_servicedate,s.service_user,d.depart_name,s.service_technician,s.service_type,s.items_id,
                i.items_code,i.brand,i.model,i.items_name,i.ipaddress,i.serial_number,i.sn_scph,sym.sym_name,s.service_symptom,s.service_symptom_text,ss.service_status_name,s.service_lastupdate,
                s.service_technician_update,s.service_remark,h.hardware_name,ht.hardware_type_id,ht.hardware_type_name,
                (select service_detail_user from service_detail where service_id = s.service_id order by service_detail_id desc limit 1) as service_detail_user,
                (select service_detail_detail from service_detail where service_id = s.service_id order by service_detail_id desc limit 1) as service_detail_detail,
                (select sds.status_id from service_detail sd left outer join service_detail_status sds on sds.status_id = sd.service_detail_status_id where sd.service_id = s.service_id order by sd.service_detail_id desc limit 1) as status_id,
                (select count(service_id) as cc from jobs_items where service_id = s.service_id limit 1) as jobs,
                (select count(service_id) as cc from parts_items where service_id = s.service_id limit 1) as parts,
                sds.status_id,sds.status_name,sds.status_color
                
                from service s
                left outer join service_status ss on ss.service_status_id = s.service_status_id
                left outer join symptom sym on sym.sym_id = s.service_symptom
                left outer join depart d on d.depart_id = s.service_depart
                left outer join items i on i.items_id = s.items_id
                left outer join hardware h on h.hardware_id = i.hardware_id
                left outer join hardware_type ht on ht.hardware_type_id = h.hardware_type_id
                left outer join service_detail_status sds on sds.status_id = s.service_detail_status_id
                left outer join db_skh.personal p on p.person_id = s.service_technician
                where 1 {$subQuery} order by s.service_id desc {$limit}";
        //echo $sql;
        return $this->db->select($sql);
        //echo json_encode($data);
    }

    public function xhrSelectById($service_id = null) {
        $service_id = (is_null($service_id)) ? $_POST['service_id'] : $service_id;
        return $this->db->select("select s.service_id, s.service_no, s.service_regdate, s.service_year,s.service_servicedate,s.service_user,s.service_depart,s.service_technician,s.service_type,s.items_id,d.depart_name,
                i.items_code,i.brand,i.model,i.items_id,i.items_name,i.ipaddress,i.serial_number,i.sn_scph,concat(TIMESTAMPDIFF(year,i.buydate,date(NOW())),' ','ปี') as age_y,
                sym.sym_name,s.service_symptom, s.service_symptom_text,ss.service_status_name,s.service_lastupdate,
                s.service_technician_update,s.service_remark,h.hardware_name,ht.hardware_type_id,ht.hardware_type_name, concat(' [',d2.depart_name,' ]') as items_depart_name,s.service_text,s.service_status_id,
                s.service_cause, s.service_cause_text, s.service_kpi3day, s.service_kpi3day_text,
                (select service_detail_user from service_detail where service_id = s.service_id order by service_detail_id desc limit 1) as service_detail_user,
                (select service_detail_detail from service_detail where service_id = s.service_id order by service_detail_id desc limit 1) as service_detail_detail,
                (select sds.status_id from service_detail sd left outer join service_detail_status sds on sds.status_id = sd.service_detail_status_id where sd.service_id = s.service_id order by sd.service_detail_id desc limit 1) as status_id,
                (select sds.status_name from service_detail sd left outer join service_detail_status sds on sds.status_id = sd.service_detail_status_id where sd.service_id = s.service_id order by sd.service_detail_id desc limit 1) as status_name,
                (select sds.status_color from service_detail sd left outer join service_detail_status sds on sds.status_id = sd.service_detail_status_id where sd.service_id = s.service_id order by sd.service_detail_id desc limit 1) as status_color

                from service s
                left outer join service_status ss on ss.service_status_id = s.service_status_id
                left outer join symptom sym on sym.sym_id = s.service_symptom
                left outer join depart d on d.depart_id = s.service_depart
                left outer join items i on i.items_id = s.items_id
                left outer join hardware h on h.hardware_id = i.hardware_id
                left outer join hardware_type ht on ht.hardware_type_id = h.hardware_type_id
                left outer join depart d2 on d2.depart_id = i.depart_id
                left outer join db_skh.personal p on p.person_id = s.service_technician
                where s.service_id  = '{$service_id}' ");
    }

    public function xhrSelectServiceYear() {
        $sql = " SELECT if (MONTH(NOW()) between '10' and '12', year(NOW())+543+1, year(NOW())+543) as service_year
                UNION
                SELECT (service_year+1) as service_year from service 
		UNION
                SELECT service_year from service 
		UNION
		SELECT (service_year-1) as service_year from service 
		GROUP BY service_year
                ";

        return $this->db->select($sql);
    }

    public function xhrSelectServiceCause() {
        $sql = " SELECT * from service_cause where service_cause_status = '1' ORDER BY sort ";

        return $this->db->select($sql);
    }

    public function xhrSelectByIdForPDF($id) {

        //SQL for PDF

        $sql = "select s.service_id, s.service_no,DATE_FORMAT(s.service_regdate,'%d-%m-%Y') as service_regdate,s.service_year,DATE_FORMAT(s.service_servicedate,'%d-%m-%Y') as service_servicedate,s.service_user,s.service_depart,d.depart_name,s.service_technician,s.service_type,s.items_id,
                i.items_code,i.brand,i.model,i.items_name,i.ipaddress,i.serial_number,i.sn_scph,sym.sym_name,s.service_symptom, s.service_symptom_text, sym.sym_sort,ss.service_status_name,DATE_FORMAT(s.service_lastupdate,'%d-%m-%Y') as service_lastupdate,
                s.service_technician_update,s.service_remark,h.hardware_name,ht.hardware_type_id,ht.hardware_type_name, concat(' [',d2.depart_name,' ]') as items_depart_name,s.service_text,s.service_status_id,
                (select service_detail_user from service_detail where service_id = s.service_id order by service_detail_id desc limit 1) as service_detail_user,
                (select service_detail_detail from service_detail where service_id = s.service_id order by service_detail_id desc limit 1) as service_detail_detail,
                (select sds.status_id from service_detail sd left outer join service_detail_status sds on sds.status_id = sd.service_detail_status_id where sd.service_id = s.service_id order by sd.service_detail_id desc limit 1) as status_id,
                (select sds.status_name from service_detail sd left outer join service_detail_status sds on sds.status_id = sd.service_detail_status_id where sd.service_id = s.service_id order by sd.service_detail_id desc limit 1) as status_name,
                (select sds.status_color from service_detail sd left outer join service_detail_status sds on sds.status_id = sd.service_detail_status_id where sd.service_id = s.service_id order by sd.service_detail_id desc limit 1) as status_color

                from service s
                left outer join service_status ss on ss.service_status_id = s.service_status_id
                left outer join symptom sym on sym.sym_id = s.service_symptom
                left outer join depart d on d.depart_id = s.service_depart
                left outer join items i on i.items_id = s.items_id
                left outer join hardware h on h.hardware_id = i.hardware_id
                left outer join hardware_type ht on ht.hardware_type_id = h.hardware_type_id
                left outer join depart d2 on d2.depart_id = i.depart_id
                where s.service_id  = '{$id}' ";


//        $sth = $this->db->prepare($sql);
//        $sth->execute();
//        $data = $sth->fetch(PDO::FETCH_ASSOC);
//
//        return $data;
        return $this->db->select($sql);
    }

    public function xhrGetServiceDetailForPDF($id = null) {

        //SQL for PDF
        $id = (is_null($id)) ? $_POST['service_id'] : $id;
        $sql = "select sd.service_detail_status_id,s.status_name,sd.service_detail_user,sd.service_detail_detail,DATE_FORMAT(sd.service_detail_datetime,'%d-%m-%Y %h:%i') as service_detail_datetime
                                from service_detail sd 
                                left outer join service_detail_status s on s.status_id = sd.service_detail_status_id
                                where sd.service_id = '{$id}'
                                order by sd.service_detail_datetime desc";
        return $this->db->select($sql);
    }

    public function xhrInsert($staff = null) {
        $sth = $this->db->prepare('INSERT INTO service (service_id, service_no, service_regdate, service_year, service_servicedate, service_user, service_depart, 
                                    service_technician, service_type, items_id, service_symptom, service_symptom_text, service_status_id, 
                                    service_text, service_lastupdate, service_technician_update, service_remark, service_detail_datetime, 
                                    service_detail_status_id, service_detail_user, service_detail_detail, service_cause, service_cause_text,
                                    service_kpi3day, service_kpi3day_text ) 
                            VALUES (:service_id, :service_no, date(now()), :service_year, :service_servicedate, :service_user, :service_depart, 
                                    :service_technician, :service_type, :items_id, :service_symptom, :service_symptom_text, :service_status_id, 
                                    :service_text, now(), :service_technician_update, :service_remark, now(), 
                                    :service_detail_status_id, :service_detail_user, :service_detail_detail,
                                    :service_cause, :service_cause_text, :service_kpi3day, :service_kpi3day_text)');
        $sth2 = $this->db->prepare('INSERT INTO service_detail (service_id, service_detail_datetime, service_detail_status_id, service_detail_user, service_detail_detail) 
                            VALUES (:service_id, :service_detail_datetime, :service_detail_status_id, :service_detail_user, :service_detail_detail)');
        if ($sth && $sth2) {
            $maxId = $this->MaxId() + 1;
            $maxNo = $this->MaxNo($_POST['service_year']) + 1;
            if ($staff == 'staff') {       ////##################### Insert By Staff
                $data = array(/////////// Insert Service
                    'service_id' => $maxId,
                    'service_no' => $maxNo,
                    'service_year' => $_POST['service_year'],
                    'service_servicedate' => $_POST['service_servicedate'],
                    'service_user' => $_POST['service_user'],
                    'service_depart' => $_POST['service_depart'],
                    'service_technician' => $_POST['userPerson_id'],
                    'service_type' => $_POST['service_type'],
                    'items_id' => $_POST['items_id'],
                    'service_symptom' => $_POST['service_symptom'],
                    'service_symptom_text' => $_POST['service_symptom_text'],
                    'service_status_id' => $_POST['service_status_id'],
                    'service_text' => $_POST['service_text'],
                    'service_technician_update' => $_POST['userPerson_id'],
                    'service_remark' => $_POST['service_remark'],
                    'service_cause' => $_POST['service_cause'],
                    'service_cause_text' => $_POST['service_cause_text'],
                    'service_kpi3day' => $_POST['service_kpi3day'],
                    'service_kpi3day_text' => $_POST['service_kpi3day_text'],
                    'service_detail_status_id' => 2,
                    'service_detail_user' => $_POST['userPerson_id'],
                    'service_detail_detail' => null
                );
                $data2 = array(/////////// Insert Service_detail
                    'service_id' => $maxId,
                    'service_detail_datetime' => date('Y-m-d h:i:s'),
                    'service_detail_status_id' => 2,
                    'service_detail_user' => $_POST['userPerson_id'],
                    'service_detail_detail' => null
                );
            } else {       ////##################### Insert By Customer
                $data = array(/////////// Insert Service
                    'service_id' => $maxId,
                    'service_no' => $maxNo,
                    'service_year' => $_POST['service_year'],
                    'service_servicedate' => null,
                    'service_year' => $_POST['service_year'],
                    'service_user' => $_POST['userPerson_id'],
                    'service_depart' => $_POST['service_depart'],
                    'service_technician' => null,
                    'service_type' => $_POST['service_type'],
                    'items_id' => $_POST['items_id'],
                    'service_symptom' => $_POST['service_symptom'],
                    'service_symptom_text' => $_POST['service_symptom_text'],
                    'service_status_id' => null,
                    'service_text' => null,
                    'service_technician_update' => null,
                    'service_remark' => null,
                    'service_detail_status_id' => 1,
                    'service_detail_user' => $_POST['userPerson_id'],
                    'service_detail_detail' => null
                );
                $data2 = array(/////////// Insert Service_detail
                    'service_id' => $maxId,
                    'service_detail_datetime' => date('Y-m-d h:i:s'),
                    'service_detail_status_id' => 1,
                    'service_detail_user' => $_POST['userPerson_id'],
                    'service_detail_detail' => 'รับเรื่อง'
                );
            }
            $sth->execute($data);
            $sth2->execute($data2);
            $data += array('sta' => 'add');

            echo json_encode($data);
        }
    }

    public function xhrUpdateById($staff = null) {

        //if ($staff == 'staff') {       ////##################### Update By Staff
            $sth = $this->db->prepare("UPDATE service SET "
                    . "service_year = :service_year, "
                    . "service_user = :service_user, "
                    . "service_depart = :service_depart, "
                    . "service_symptom = :service_symptom, "
                    // . "service_technician = :service_technician, "
                    . "service_type = :service_type, "
                    . "items_id = :items_id, "
                    . "service_symptom_text = :service_symptom_text, "
                    . "service_status_id = :service_status_id, "
                    . "service_text = :service_text, "
                    . "service_lastupdate = NOW() , "
                    . "service_technician_update = :service_technician_update, "
                    . "service_remark = :service_remark, "
                    . "service_cause = :service_cause, "
                    . "service_cause_text = :service_cause_text, "
                    . "service_kpi3day  = :service_kpi3day , "
                    . "service_kpi3day_text = :service_kpi3day_text, "
                    . "service_servicedate = :service_servicedate "
                    . "WHERE service_id = :service_id ");
            $sth->execute(array(
                ':service_year' => $_POST['service_year'],
                ':service_user' => $_POST['service_user'],
                ':service_depart' => $_POST['service_depart'],
                ':service_symptom' => $_POST['service_symptom'],
                //':service_technician' => $_POST['userPerson_id'],
                //คนรับเรื่องต้องเป็นคนเดิมห้ามเปลี่ยน ***************
                ':service_type' => $_POST['service_type'],
                ':items_id' => $_POST['items_id'],
                ':service_symptom_text' => $_POST['service_symptom_text'],
                ':service_status_id' => $_POST['service_status_id'],
                ':service_text' => $_POST['service_text'],
                ':service_technician_update' => $_POST['userPerson_id'],
                ':service_remark' => $_POST['service_remark'],
                ':service_cause' => $_POST['service_cause'],
                ':service_cause_text' => ($_POST['service_cause'] === '3' ? $_POST['service_cause_text'] : null),
                ':service_kpi3day' => $_POST['service_kpi3day'],
                ':service_kpi3day_text' => ($_POST['service_kpi3day'] === 'fail' ? $_POST['service_kpi3day_text'] : null),
                ':service_servicedate' => $_POST['service_servicedate'],
                ':service_id' => $_POST['service_id']
            ));

            $chk = $this->db->prepare("select service_detail_status_id from service where service_detail_status_id = 1 and service_id  = '{$_POST['service_id']}' ");
            $chk->execute();
            if ($chk->rowCount() <> 0) {
                $sth2 = $this->db->prepare('INSERT INTO service_detail (service_id, service_detail_datetime, service_detail_status_id, service_detail_user, service_detail_detail) 
                            VALUES (:service_id, :service_detail_datetime, :service_detail_status_id, :service_detail_user, :service_detail_detail)');
                $sth2->execute(array(/////////// Insert Service_detail
                    'service_id' => $_POST['service_id'],
                    'service_detail_datetime' => date('Y-m-d h:i:s'),
                    'service_detail_status_id' => 2,
                    'service_detail_user' => $_POST['userPerson_id'],
                    'service_detail_detail' => 'รับเรื่อง'));
            }
            $data = array('chk' => true, 'sta' => 'edit');
            echo json_encode($data);
            
       // } else {    ////##################### Update By Customer *** ยังไม่ได้ Test ส่วนของ Customer ***
       /*     $sth = $this->db->prepare("UPDATE service SET "
                    . "service_year = :service_year, "
                    . "service_user = :service_user, "
                    . "service_depart = :service_depart, "
                    . "service_type = :service_type, "
                    . "items_id = :items_id, "
                    . "service_lastupdate = NOW() , "
                    . "WHERE service_id = :service_id ");
            
            $sth->execute(array(
                ':service_year' => $_POST['service_year'],
                ':service_user' => $_POST['service_user'],
                ':service_depart' => $_POST['service_depart'],
                ':service_type' => $_POST['service_type'],
                ':items_id' => $_POST['items_id'],
                ':service_id' => $_POST['service_id']
            ));
        * */
       // }
    }

    public function xhrUpdServiceDetail($arr = null) {
        if (!is_null($arr)) {
            $service_detail_status_id = $arr['service_detail_status_id'];
            $service_detail_datetime = $arr['service_detail_datetime'];
            $service_detail_user = $arr['service_detail_user'];
            $service_detail_detail = $arr['service_detail_detail'];
            $service_id = $arr['service_id'];
        } else {
            $service_detail_status_id = $_POST['service_detail_status_id'];
            $service_detail_datetime = $_POST['service_detail_datetime'];
            $service_detail_user = $_POST['service_detail_user'];
            $service_detail_detail = $_POST['service_detail_detail'];
            $service_id = $_POST['service_id'];
        }

        // 1) Update service detail status
        $sth1 = $this->db->prepare("UPDATE service SET "
                . "service_detail_status_id = :service_detail_status_id, "
                . "service_detail_datetime = :service_detail_datetime, "
                . "service_detail_user = :service_detail_user, "
                . "service_detail_detail = :service_detail_detail "
                . "WHERE service_id = :service_id ");
        // 2) Insert new service_detail 
        $sth2 = $this->db->prepare('INSERT INTO service_detail (service_detail_id, service_id, service_detail_datetime, service_detail_status_id, service_detail_user, service_detail_detail) VALUES '
                . '(:service_detail_id, :service_id, :service_detail_datetime, :service_detail_status_id, :service_detail_user, :service_detail_detail)');

        if ($sth1 && $sth2) {
            $maxId = $this->MaxDetailId() + 1;
            $data = array(
                ':service_detail_status_id' => $service_detail_status_id,
                ':service_detail_datetime' => $service_detail_datetime,
                ':service_detail_user' => $service_detail_user,
                ':service_detail_detail' => $service_detail_detail,
                ':service_id' => $service_id
            );

            $data2 = array(/////////// Insert Service_detail
                ':service_detail_id' => $maxId,
                ':service_id' => $service_id,
                ':service_detail_datetime' => $service_detail_datetime, //date('Y-m-d h:i:s')
                ':service_detail_status_id' => $service_detail_status_id,
                ':service_detail_user' => $service_detail_user,
                ':service_detail_detail' => $service_detail_detail
            );
        }
        $sth1->execute($data);
        $sth2->execute($data2);

        $sizeCoworker = sizeof($_POST["coworker"]);
        if ($sizeCoworker > 0) {
            for ($i = 0; $i < $sizeCoworker; $i++) {
                $maxId++;
                $dataCo.=(($i == 0) ? '' : ',') . "({$maxId}, '{$_POST['service_id']}', '{$_POST['service_detail_datetime']}', '{$_POST['service_detail_status_id']}', '{$_POST['coworker'][$i]}', 'ร่วมปฏิบัติ')";
            }
            $sth3 = $this->db->prepare('INSERT INTO service_detail (service_detail_id, service_id, service_detail_datetime, service_detail_status_id, service_detail_user, service_detail_detail) VALUES ' . $dataCo);
            $sth3->execute();
        }

        $data = array('chk' => true);
        echo json_encode($data);
    }

    public function xhrGetServiceDetail($service_id = null) {
        $service_id = (is_null($service_id)) ? $_POST['service_id'] : $service_id;
        return $this->db->select("select sd.service_id, sd.service_detail_id, sd.service_detail_status_id, s.status_name, sd.service_detail_user, sd.service_detail_detail, sd.service_detail_datetime 
                                from service_detail sd 
                                left outer join service_detail_status s on s.status_id = sd.service_detail_status_id
                                where sd.service_id = '{$service_id}'
                                order by sd.service_detail_datetime");
    }

    public function CountCoworker() {
        return $this->db->select("select count(service_detail_id) as cc from service_detail where service_id = '{$_POST['service_id']}'");
    }

    public function deleteServiceDetail() {
        $sth = $this->db->prepare("DELETE FROM service_detail WHERE service_detail_id = '{$_POST['service_detail_id']}'");
        $sth->execute();

        $serviceData = $this->db->select("SELECT * FROM service_detail WHERE service_id = '{$_POST['service_id']}' order by service_detail_id desc limit 1");
        $sth1 = $this->db->prepare("UPDATE service SET "
                . "service_detail_status_id = '{$serviceData[0]['service_detail_status_id']}', "
                . "service_detail_datetime = '{$serviceData[0]['service_detail_datetime']}', "
                . "service_detail_user = '{$serviceData[0]['service_detail_user']}', "
                . "service_detail_detail = '{$serviceData[0]['service_detail_detail']}' "
                . "WHERE service_id = '{$serviceData[0]['service_id']}' ");
        $sth1->execute();
        return true;
    }

    public function getDetailTextById() {
        $data = $this->db->select("SELECT service_detail_detail as detailText FROM service WHERE service_id  = '{$_POST['service_id']}' ");
        return $data;
    }

    public function xhrDeleteById() {
        $logged = Session::get('User');
//        $sth = $this->db->prepare("UPDATE service SET service_detail_status_id = '0' WHERE service_id = '{$_POST['service_id']}'");
//        $sth2 = $this->db->prepare("DELETE FROM service_detail WHERE service_id = '{$_POST['service_id']}'");
//        $sth->execute();
//        $sth2->execute();
//        
        // 1) Update service detail status
        $sth1 = $this->db->prepare("UPDATE service SET "
                . "service_detail_status_id = :service_detail_status_id, "
                . "service_detail_datetime = now(), "
                . "service_detail_user = :service_detail_user, "
                . "service_detail_detail = :service_detail_detail "
                . "WHERE service_id = :service_id ");
        // 2) Insert new service_detail 
        $sth2 = $this->db->prepare('INSERT INTO service_detail (service_detail_id, service_id, service_detail_datetime, service_detail_status_id, service_detail_user, service_detail_detail) VALUES '
                . '(:service_detail_id, :service_id, now(), :service_detail_status_id, :service_detail_user, :service_detail_detail)');

        if ($sth1 && $sth2) {
            $maxId = $this->MaxDetailId() + 1;
            $data = array(
                ':service_detail_status_id' => '0',
//                ':service_detail_datetime' => $_POST['service_detail_datetime'],
                ':service_detail_user' => $logged['person_id'],
                ':service_detail_detail' => 'ลบใบแจ้งซ่อม',
                ':service_id' => $_POST['service_id']
            );

            $data2 = array(/////////// Insert Service_detail
                ':service_detail_id' => $maxId,
                ':service_id' => $_POST["service_id"],
//                ':service_detail_datetime' => $_POST["service_detail_datetime"], //date('Y-m-d h:i:s')
                ':service_detail_status_id' => '0',
                ':service_detail_user' => $logged['person_id'],
                ':service_detail_detail' => 'ลบใบแจ้งซ่อม'
            );
        }
        $sth1->execute($data);
        $sth2->execute($data2);
    }

    public function xhrCheckUseById() {
        $sth = $this->db->prepare("SELECT * FROM service_detail WHERE service_id = '{$_POST['service_id']}'");
        $sth->execute();

        if ($sth->rowCount() > 1) {
            return false;
        } else {
            return true;
        }
    }

    public function insertCoworker($arr) {
        $sql = 'INSERT INTO service_coworker(coworker_id,coworker,service_id) '
                . 'VALUES(:coworker_id,:coworker,:service_id)';

        if ($sth && $sth2) {
            $maxCoworkerId = $this->MaxCoworkerId() + 1;
            if ($staff == 'staff') {       ////##################### Insert By Staff
                $data = array(/////////// Insert Service
                    'coworker_id' => $maxCoworkerId,
                    'coworker' => $arr['service_coworker'],
                    'service_id' => $_POST['service_id']
                );
            } else {
                //no
            }
            $sth->execute($data);
        }
    }

    public function MaxId() {
        $sth = $this->db->prepare("SELECT MAX(service_id) as service_id FROM service");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['service_id'];
    }

    public function MaxNo($year) {
        $sth = $this->db->prepare("SELECT MAX(service_no) as service_no FROM service WHERE service_year = '{$year}'");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['service_no'];
    }

    public function MaxDetailId() {
        $sth = $this->db->prepare("SELECT MAX(service_detail_id) as service_detail_id FROM service_detail");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['service_detail_id'];
    }

    public function MaxCoworkerId() {
        $sth = $this->db->prepare("SELECT MAX(coworker_id) as coworker_id FROM service_coworker");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['coworker_id'];
    }

    public function Pagination() {
        $logged = Session::get('User');
        $subQuery .= (($logged['type'] == 'staff') ? '' : " and d.office_sit = '{$logged['ward_id']}' ");
        $word = explode(' ', $_POST['search']);

        if ($_POST['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(concat(p.person_firstname,' ',p.person_lastname),concat(s.service_year,'/',s.service_no),i.sn_scph,i.brand,i.model,i.items_name,i.ipaddress,i.serial_number,h.hardware_name,d.depart_name) like '%{$value}%' ";
            }
        }
        if ($_POST['statusDetail']) {
            $i = 0;
            $detailList = $_POST['statusDetail'];
            $subQuery .= " AND ";
            $subQuery .= " s.service_detail_status_id in ( ";
            foreach ($detailList as $value) {
                $i++;
                IF ($i > 1) {
                    $subQuery .= " , ";
                }

                $subQuery .= " '" . $value . "' ";
            }
            $subQuery .= ") ";
        }

        $sql = "select s.service_id
                from service s
                left outer join service_status ss on ss.service_status_id = s.service_status_id
                left outer join symptom sym on sym.sym_id = s.service_symptom
                left outer join depart d on d.depart_id = s.service_depart
                left outer join items i on i.items_id = s.items_id
                left outer join hardware h on h.hardware_id = i.hardware_id
                left outer join hardware_type ht on ht.hardware_type_id = h.hardware_type_id
                left outer join service_detail_status sds on sds.status_id = s.service_detail_status_id
                left outer join db_skh.personal p on p.person_id = s.service_technician
                where 1 {$subQuery}";
        //echo $sql;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));

        echo json_encode($data);
    }

}
