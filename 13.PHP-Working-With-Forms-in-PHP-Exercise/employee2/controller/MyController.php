<?php

class MyController extends Controller {

    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function main() {
        
    }

    public function route() {

        $get = $this->inputGet($_GET);
        if (!empty($get['controller'])) {
            $controller = $get['controller'];
        } else {
            $controller = "MainController";
        }

        if (!empty($get['action'])) {
            $action = $get['action'];
        } else {
            $action = "main";
        }
        
        $c = new $controller($this->db);
        $mc = get_class_methods($c);
        if (in_array($action, $mc)) {
            $c->$action();
        } else {
            include 'view/404.php';
        }
    }

}
