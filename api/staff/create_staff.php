<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
include_once '../../includes/Database.php';
include_once '../../includes/Staff.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name) || !isset($data->email) || !isset($data->address) || !isset($data->phone) || !isset($data->role)) {
    echo json_encode(array("message" => "All fields are required."));
    exit();
}

$database = new Database();
$db = $database->getConnection();

$staff = new Staff($db);
$staff->name = $data->name;
$staff->email = $data->email;
$staff->address = $data->address;
$staff->phone = $data->phone;
$staff->role = $data->role;

if ($staff->create()) {
    echo json_encode(array("message" => "Staff created successfully."));
} else {
    echo json_encode(array("message" => "Failed to create staff."));
}
?>
