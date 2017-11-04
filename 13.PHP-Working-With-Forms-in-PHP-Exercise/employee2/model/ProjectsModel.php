<?php

class ProjectsModel extends Model {

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->table = 'projects';
    }

    public function create(array $project) {
        try {
            $this->db->beginTransaction();
            $db_stm = $this->db->prepare("INSERT INTO `" . $this->table . "` "
                    . "(`name`,`description`,`end_date`) "
                    . "VALUES (?,?,?);");
            $db_stm->bindParam(1, $project['name']);
            $db_stm->bindParam(2, $project['description']);
            $db_stm->bindParam(3, $project['end_date']);
            $db_stm->execute();
            $project_id = $this->db->lastInsertId();
            $db_stm = $this->db->prepare("INSERT INTO `employees_projects` "
                    . "(`employee_id`, `project_id`) "
                    . "VALUES (:empl_id, :pr_id);");
            $db_stm->bindParam(":empl_id", $project['employee_id']);
            $db_stm->bindParam(":pr_id", $project_id);
            $db_stm->execute();
            if ($this->db->commit()) {
                return 'Project "' . $project['name'] . '" for employee ID'
                        . $project['employee_id'] . ' save in database';
            }

            $db_stm = null;
            $this->db = null;
        } catch (PDOException $e) {
            $this->db->rollBack();
            include 'view/error_page.php';
        }
        return false;
    }

    public function read(int $empl_id) {
        try {

            $db_stm = $this->db->prepare("SELECT * "
                    . "FROM `" . $this->table . "` AS p, `employees_projects` AS ep "
                    . "WHERE `p`.`project_id`=`ep`.`project_id`"
                    . "AND `ep`.employee_id=:id;");
            $db_stm->bindParam(":id", $empl_id);
            if ($db_stm->execute()) {
                return $db_stm->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            include 'view/error_page.php';
        }
        return false;
    }

}
