<?php
include_once '../../includes/Database.php';
include_once '../../includes/Staff.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->name) || !isset($data->email) || !isset($data->address) || !isset($data->phone) || !isset($data->role)) {
    echo json_encode(array("message" => "All fields are required."));
    exit();
}

$database = new Database();
$db = $database->getConnection();

$staff = new Staff($db);
$staff->id = $data->id;
$staff->name = $data->name;
$staff->email = $data->email;
$staff->address = $data->address;
$staff->phone = $data->phone;
$staff->role = $data->role;

if ($staff->update()) {
    echo json_encode(array("message" => "Staff updated successfully."));
} else {
    echo json_encode(array("message" => "Failed to update staff."));
}
?>
