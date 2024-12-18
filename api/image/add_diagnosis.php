<?php
include_once '../../includes/Database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));
$image_id = $data->image_id;
$diagnosis_report = $data->diagnosis_report;

// Database connection
$database = new Database();
$db = $database->getConnection();

// Update image with diagnosis report
$query = "UPDATE images SET diagnosis_report = :diagnosis_report, upload_status = 'Diagnosed', diagnosed_at = NOW() WHERE id = :image_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':image_id', $image_id);
$stmt->bindParam(':diagnosis_report', $diagnosis_report);

if ($stmt->execute()) {
    echo json_encode(["message" => "Diagnosis report added successfully."]);
} else {
    echo json_encode(["message" => "Failed to add diagnosis report."]);
}
?>
