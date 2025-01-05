<?php
// Include the Database class
include_once '../includes/Database.php';

// Set response header to JSON
header('Content-Type: application/json');

// Instantiate the Database class
$database = new Database();
$conn = $database->getConnection();

// SQL query to select all patients
$query = "SELECT * FROM patients";

// Prepare the SQL statement
$stmt = $conn->prepare($query);

// Execute the query
$stmt->execute();

// Check if any records were found
if ($stmt->rowCount() > 0) {
    // Create an array to store patient data
    $patients = array();
    
    // Fetch all records
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add the record to the patients array
        $patients[] = $row;
    }
    
    // Return the response as JSON
    echo json_encode($patients);
} else {
    // If no records found, return a message
    echo json_encode(array("message" => "No patients found."));
}

$conn = null; // Close connection
?>
