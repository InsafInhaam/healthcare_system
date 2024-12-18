<?php

header("Content-Type: application/json");
include_once '../includes/Database.php';
include_once '../includes/Patient.php';

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->address) &&
    !empty($data->conditions) &&
    !empty($data->diagnosis)
) {
    $patient->name = $data->name;
    $patient->address = $data->address;
    $patient->conditions = $data->conditions;
    $patient->diagnosis = $data->diagnosis;

    if ($patient->create()) {
        echo json_encode(["message" => "Patient created successfully."]);
    } else {
        echo json_encode(["message" => "Unable to create patient."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
