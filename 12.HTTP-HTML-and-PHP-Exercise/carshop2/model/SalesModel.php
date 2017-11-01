<?php

class SalesModel extends Model {

    private $date_time;
    private $amount;
    private $car_id;
    private $customer_id;

    public function __construct(PDO $db,int $car_id=null, int $customer_id=null, int $amount=null) {
        parent::__construct($db);
        $this->car_id = $car_id;
        $this->customer_id = $customer_id;
        $this->amount = $amount;
        $this->table = 'sales';
    }

    public function create() {
        // Insert into sales
        try {
            $stmt = $this->db->prepare("
                INSERT INTO `" . $this->table . "`
                  (`date_time`,`amount`,`car_id`,`customer_id`)
                VALUES 
                   (NOW(), ?, ?, ?)");
            $stmt->bindParam(1, $this->amount);
            $stmt->bindParam(2, $this->car_id);
            $stmt->bindParam(3, $this->customer_id);
            $stmt->execute();
            $sale_id = $this->db->lastInsertId();
            $this->db->commit();
            return($sale_id);
        } catch (PDOException $e) {
            $this->db->rollBack();
            include 'view/error_page.php';
        }
        return false;
    }

    // Todo - problem 1
    // Modifications to create()

    public function readAll() {
        try {
            $stmt = $this->db->prepare("
              SELECT *         
                FROM `deal`");
            $stmt->execute();
            $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ($all);
        } catch (PDOException $e) {
            include 'view/error_page.php';
        }
    }

    public function readTotal() {
        $stmt = $this->db->prepare("
            SELECT SUM(`amount`) as `total_amount`
              FROM `sales`");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['total_amount'])
            return $row['total_amount'];
        else
            return false;
    }
    public function getSale(int $sale_id) {
        try {
            $this->db->beginTransaction();

            $db_stm = $this->db->prepare("SELECT `date_time` "
                    . "FROM `" . $this->table . "` "
                    . "WHERE `id`=:sale_id "
                    . "LIMIT 1;");
            $db_stm->bindParam(":sale_id", $sale_id);
            $db_stm->execute();
            $datetime_of_sale = $db_stm->fetch(PDO::FETCH_ASSOC);
            $this->db->commit();
            $db_stm = null;
            $db = null;
            if (isset($datetime_of_sale)) {
                return "New sale entered " . $datetime_of_sale['date_time'] . PHP_EOL;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            include 'view/error_page.php';
        }
    }
    public function updateSale(array $sale) {
        try {
            $this->date_time = $sale['date_time'];
            $this->amount = $sale['amount'];
            $this->id = $sale['id'];
            $stmt = $this->db->prepare("
              UPDATE `" . $this->table . "`
                SET `date_time`=?, `amount`=? 
                WHERE `id`=?;");
            $stmt->bindParam(1, $this->date_time);
            $stmt->bindParam(2, $this->amount);
            $stmt->bindParam(3, $this->id);
            $stmt->execute();
            return "Sale with ID ".$this->id." updated.";
        } catch (PDOException $e) {
            $this->db->rollBack();
            include 'view/error_page.php';
        }
    }
}
