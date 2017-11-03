<?php

class EmployeesModel extends Model {

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->table = 'employees';
    }

    public function readAll() {
        $stmt = $this->db->prepare("SELECT * "
                . "FROM `" . $this->table . "`;");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}
