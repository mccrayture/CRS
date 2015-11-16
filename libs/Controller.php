<?php

class Controller {

    function __construct() {
        //echo 'Main Controllers </br>';
        $this->view = new View();
    }

    public function loadModel($name) {
        $path = 'models/' . $name . '_model.php';
        if (file_exists($path)) {
            require_once $path;

            $modelName = $name . '_Model';
            $this->model = new $modelName();
        }
    }

    public function unloadModel() {
//        $modelName = $name . '_Model';
       unset($this->model);
    }

}
