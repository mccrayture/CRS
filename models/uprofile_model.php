<?php

class Uprofile_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function updatePersonByID() {
        
        /* 
         * Under construction อยู่ในระหว่างการทดสอบ ว่าจะอัพเดตข้อมูลของ skh หรือไม่
         */
        
        $sth = $this->db_user->prepare("SELECT p.* FROM personal p WHERE p.person_id = '{$_POST['person_id']}'");
        $sth->execute();
        
        if(!empty($_POST['person_password']))
        {
            if ($sth->rowCount() > 0) {
                $sql = "UPDATE personal "
                        . " SET "
                        . " person_username = :person_username,"
                        . " person_password = :person_password,"
                        . " person_prefix = :person_prefix"
                        . " person_fname = :person_fname"
                        . " person_lname = :person_lname"
                        . " position_id = :person_position"
                        . " office_id = :person_office"
                        . " WHERE person_id = :person_id ";
            }

            $sth1 = $this->db->prepare($sql);
            $sth1->execute(array(
                ':person_username' => $_POST['person_username'],
                ':person_password' => $_POST['person_password'],
                ':person_prefix' => $_POST['person_prefix'],
                ':person_fname' => $_POST['person_fname'],
                ':person_lname' => $_POST['person_lname'],
                ':person_position' => $_POST['person_position'],
                ':person_office' => $_POST['person_office'],
                ':person_id' => $_POST['person_id']
            ));
        }
        else
        {
            //not update password if user hasn't change password
            if ($sth->rowCount() > 0) {
                $sql = "UPDATE personal "
                        . " SET "
                        . " person_username = :person_username,"
                        //. " person_password = :person_password,"
                        . " person_prefix = :person_prefix"
                        . " person_fname = :person_fname"
                        . " person_lname = :person_lname"
                        . " position_id = :person_position"
                        . " office_id = :person_office"
                        . " WHERE person_id = :person_id ";
            }

            $sth1 = $this->db_user->prepare($sql);
            $sth1->execute(array(
                ':person_username' => $_POST['person_username'],
                //':person_password' => $_POST['person_password'],
                ':person_prefix' => $_POST['person_prefix'],
                ':person_fname' => $_POST['person_fname'],
                ':person_lname' => $_POST['person_lname'],
                ':person_position' => $_POST['person_position'],
                ':person_office' => $_POST['person_office'],
                ':person_id' => $_POST['person_id']
            ));
        }
        echo $sql;
        
    }
    
    public function loadImg($id){
        $sth = $this->db->prepare("SELECT pic FROM pic WHERE technician_id = '{$id}'");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['pic'];
    }

}
