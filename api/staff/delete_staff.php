<?php
include_once '../../includes/Database.php';
include_once '../../includes/Staff.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? $_GET['id'] : die("Staff ID is required");

$database = new Database();
$db = $database->getConnection();

$staff = new Staff($db);
$staff->id = $id;

if ($staff->delete()) {
    echo json_encode(array("message" => "Staff deleted successfully."));
} else {
    echo json_encode(array("message" => "Failed to delete staff."));
}
?>
