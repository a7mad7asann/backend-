<?php
class Employee {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllEmployeesByManager($manager_id) {
        $stmt = $this->conn->prepare("SELECT * FROM employee WHERE manager_id = :manager_id");
        $stmt->bindValue(':manager_id', $manager_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addEmployee($name, $email, $phone, $picture, $manager_id) {
        $stmt = $this->conn->prepare("INSERT INTO employee (name, email, phone, picture, manager_id) VALUES (:name, :email, :phone, :picture, :manager_id)");
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':picture', $picture);
        $stmt->bindValue(':manager_id', $manager_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteEmployee($id) {
        $stmt = $this->conn->prepare("DELETE FROM employee WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function updateEmployee($id, $name, $email, $phone, $picture) {
        $stmt = $this->conn->prepare("UPDATE employee SET name = :name, email = :email, phone = :phone, picture = :picture WHERE id = :id");
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':picture', $picture);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getEmployeeById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM employee WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
