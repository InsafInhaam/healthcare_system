<?php
// Include the Database class
include_once '../includes/Database.php';

// Get the patient ID from the query string
$id = isset($_GET['id']) ? $_GET['id'] : die();

// Set response header to JSON
header('Content-Type: application/json');

// Instantiate the Database class
$database = new Database();
$conn = $database->getConnection();

// SQL query to select a patient by ID
$query = "SELECT * FROM patients WHERE id = :id";

// Prepare the SQL statement
$stmt = $conn->prepare($query);

// Bind the ID parameter to the prepared statement
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Check if any record was found
if ($stmt->rowCount() > 0) {
    // Fetch the patient data
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Return the response as JSON
    echo json_encode($patient);
} else {
    // If no record found, return a message
    echo json_encode(array("message" => "Patient not found."));
}

$conn = null; // Close connection
?>
