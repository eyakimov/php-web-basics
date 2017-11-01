<?php

class CustomersModel extends Model {

    private $name;
    private $family;
    private $id;

    public function __construct(PDO $db, array $customer = null) {
        parent::__construct($db);
        $this->name = $customer['name'];
        $this->family = $customer['family'];
        $this->table = 'customers';
    }

    public function create() {
        // Insert into customers
        try {
            $stmt = $this->db->prepare("
              INSERT INTO `" . $this->table . "`
                (`first_name`, `family_name`)
              VALUES
                (?, ?)");
            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->family);
            $stmt->execute();
            $customer_id = $this->db->lastInsertId();
            return($customer_id);
        } catch (PDOException $e) {
            $this->db->rollBack();
            include 'view/error_page.php';
        }
        return false;
    }

    //Todo - problem 2
    // Read all customers
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

    public function updateCustomer(array $customer) {
        try {
            $this->name = $customer['first_name'];
            $this->family = $customer['family_name'];
            $this->id = $customer['id'];
            $stmt = $this->db->prepare("
              UPDATE `" . $this->table . "`
                SET `first_name`=?, `family_name`=? 
                WHERE `id`=?;");
            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->family);
            $stmt->bindParam(3, $this->id);
            $stmt->execute();
            return "Customer with ID ".$this->id." updated.";
        } catch (PDOException $e) {
            $this->db->rollBack();
            include 'view/error_page.php';
        }
        return false;
    }

}
