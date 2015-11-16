<?php

class Model {

    function __construct() {
        $this->db = new Database(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->db_user = new Database(DB_USER_TYPE . ':host=' . DB_USER_HOST . ';dbname=' . DB_USER_NAME, DB_USER_USER, DB_USER_PASS);
    }

}
