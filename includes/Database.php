<?php
class Database
{
    private $host = "localhost";
    private $db_name = "healthcare_system";  // Your database name
    private $username = "root";  // MySQL username for XAMPP
    private $password = "";      // MySQL password for XAMPP
    private $conn;

    // Get database connection
    public function getConnection()
    {
        $this->conn = null;

        try {
            // Create PDO connection
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // If connection fails, catch the exception and display the error message
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

}
?>