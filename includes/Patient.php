<?php

class Patient {
    private $conn;
    private $table_name = "patients";

    public $id;
    public $name;
    public $address;
    public $conditions;
    public $diagnosis;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new patient
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, address=:address, conditions=:conditions, diagnosis=:diagnosis";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":conditions", $this->conditions);
        $stmt->bindParam(":diagnosis", $this->diagnosis);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Update patient details
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, address=:address, conditions=:conditions, diagnosis=:diagnosis WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":conditions", $this->conditions);
        $stmt->bindParam(":diagnosis", $this->diagnosis);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete patient
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
