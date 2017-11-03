<?php

class AddressesModel extends Model
{
public function __construct(PDO $db) {
        parent::__construct($db);
        $this->table = 'addresses';
    }
    public function read(int $empl_id) {
        try {

            $db_stm = $this->db->prepare("SELECT `a`.`address_text` AS address, `e`.`first_name`, `e`.`last_name`, `t`.`name` AS town "
                ."FROM `towns` AS t, `addresses` AS a  "
                    ."INNER JOIN `employees` AS e USING(`address_id`) "
                    ."INNER JOIN `towns` USING(`town_id`) "
                    ."WHERE `e`.`employee_id`=:id "
                    ."GROUP BY `e`.`employee_id`;");

            $db_stm->bindParam(":id", $empl_id);
            if ($db_stm->execute()) {
                return $db_stm->fetchAll(PDO::FETCH_ASSOC);
            }
            $db_stm=null;
            $this->db;
        } catch (PDOException $e) {
            include 'view/error_page.php';
        }
        return false;
    }

}