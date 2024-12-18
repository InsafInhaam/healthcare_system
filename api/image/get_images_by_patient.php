<?php
include_once '../../includes/Database.php';

header('Content-Type: application/json');

// Get patient ID from query
$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : die("Patient ID is required");

// Database connection
$database = new Database();
$db = $database->getConnection();

// Fetch images for the patient
$query = "SELECT * FROM images WHERE patient_id = :patient_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':patient_id', $patient_id);
$stmt->execute();

$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($images);
?>
