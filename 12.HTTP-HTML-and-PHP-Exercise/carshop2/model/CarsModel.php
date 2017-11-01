<?php

class CarsModel extends Model {

    private $make;
    private $model;
    private $year;

    public function __construct(PDO $db, array $car=null) {
        parent::__construct($db);
        $this->make = $car['make'];
        $this->model = $car['model'];
        $this->year = $car['year'];
        $this->table = "cars";
    }

    public function create() {
        try {
            // Insert into car
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("
              INSERT INTO `" . $this->table . "`
                (`make`, `model`, `year`)
              VALUES
                (?, ?, ?)");
            $stmt->bindParam(1, $this->make);
            $stmt->bindParam(2, $this->model);
            $stmt->bindParam(3, $this->year);
            $stmt->execute();
            $car_id = $this->db->lastInsertId();
            return $car_id;
        } catch (PDOException $e) {
            $this->db->rollBack();
            include 'view/error_page.php';
        }
        return false;
    }

        public function readAll() {
                try {
            $stmt = $this->db->prepare("
              SELECT *         
                FROM `" . $this->table . "`");
            $stmt->execute();
            $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ($all);
        } catch (PDOException $e) {
            include 'view/error_page.php';
        }
        
    }
    // Todo - problem 6
    // Method/s to search for a car and owner. Use join
    public function searchCarOwner(string $car) {
                        try {
            $stmt = $this->db->prepare("
              SELECT `c`.`make`, `c`.`model`, `c`.`year`, `c`.`id` AS car_id, 
              `cs`.`first_name`, `cs`.`family_name`, `cs`.`id` AS customer_id          
                FROM `customers` AS cs, `" . $this->table . "` AS c "
                    . "INNER JOIN `sales` AS s ON `c`.`id`=`s`.`car_id` "
                    . "WHERE `c`.`make`=:car "
                    . "GROUP BY `c`.`id`;");
            $stmt->bindParam(':car', $car);
            $stmt->execute();
            $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ($all);
        } catch (PDOException $e) {
            include 'view/error_page.php';
        }
    }
    public function updateCar(array $car) {
        try {
            $this->make = $car['make'];
            $this->model = $car['model'];
             $this->model = $car['year'];
            $this->id = $car['id'];
            $stmt = $this->db->prepare("
              UPDATE `" . $this->table . "`
                SET `make`=?, `model`=?, `year`=? 
                WHERE `id`=?;");
            $stmt->bindParam(1, $this->make);
            $stmt->bindParam(2, $this->model);
            $stmt->bindParam(3, $this->year);
            $stmt->bindParam(4, $this->id);
            $stmt->execute();
            return "Car with ID ".$this->id." updated.";
        } catch (PDOException $e) {
            $this->db->rollBack();
            include 'view/error_page.php';
        }
    }
}
