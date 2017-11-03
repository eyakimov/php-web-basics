<?php

abstract class Controller {

    protected $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    abstract public function main();

    protected function loadView(string $filename, array $params = null) {
        if (file_exists("view/" . $filename)) {
            include "view/" . $filename;
        } else {
            throw new Exception('View not found!');
        }
    }

   protected function inputGet(array $get) {

        $args = array(
            'controller' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'action' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'employee_id' => FILTER_VALIDATE_INT,
        );

        return filter_var_array($get, $args);
    }

    protected function inputPost(array $post) {
        $args = array(
            'name' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'description' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'end_date' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'save'=>array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'cancel'=>array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
        );

        return filter_var_array($post, $args);
    }

    protected function inputRequest(array $request) {
        $args = array(
            'controller' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'action' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'employee_id' => FILTER_VALIDATE_INT,
            'name' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'description' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'end_date' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'save'=>array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
            'cancel'=>array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW),
        );
        return filter_var_array($request, $args);
    }

}
