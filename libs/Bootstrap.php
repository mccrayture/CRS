<?php

class Bootstrap {

    function __construct() {
        $logged = Session::get('User');
        $url = explode('/', rtrim((isset($_GET['url']) ? $_GET['url'] : null), '/'));
        #print_r($url);

        if (empty($url[0])) {
            require 'controllers/index.php';
            $controller = new Index();
            $controller->index();
            return false;
        }

        $file = 'controllers/' . $url[0] . '.php';
        if (file_exists($file)) {
            
            if (sizeof($logged) > 0 || $url[0] == 'login' || $url[0] == 'about' || $url[0] == 'manual') {
                require $file;
            } else {
                $this->loginFalse();
                return false;
            }
        } else {
            $this->error();
            return false;
        }
        
        
        $controller = new $url[0]; 
        $controller->loadModel($url[0]); 
        $controller->view->pageMenu = $url[0];

        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
            } else {
                $this->error();
            }
        } else if (isset($url[1])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}();
            } else {
                $this->error();
            }
        } else {
            $controller->index();
        }
        
         //var_dump($url[0]);
         //var_dump($logged['CRS_system']);
    }

    function error() {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->index();
        return false;
    }

    function loginFalse() {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->notLogin();
        return false;
    }

    function accessDenied() {
        require 'controllers/denied.php';
        $controller = new Denied();
        $controller->index();
        return false;
    }

    function accessRight($controller, $type_user) {
        if((in_array($controller, array('service','reports','service_status','service_detail_status','technician','depart','symptom','jobs','hardware_type','hardware','items','store_type','store'))) && ($type_user === 'staff')){
            return 'success';
            
        }else if((in_array($controller, array('service'))) && ($type_user === 'user')){
            return 'success';
            
        }else{
            return 'no_success';
        }
        
    }
    
}
