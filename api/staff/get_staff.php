<?php
include_once '../../includes/Database.php';
include_once '../../includes/Staff.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? $_GET['id'] : die("Staff ID is required");

$database = new Database();
$db = $database->getConnection();

$staff = new Staff($db);
$staff->id = $id;
$stmt = $staff->readOne();

if ($stmt->rowCount() > 0) {
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
} else {
    echo json_encode(array("message" => "Staff not found."));
}
?>
