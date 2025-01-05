<?php

header("Content-Type: application/json");
include_once '../includes/Database.php';
include_once '../includes/Patient.php';

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->id) &&
    !empty($data->name) &&
    !empty($data->address) &&
    !empty($data->conditions) &&
    !empty($data->diagnosis)
) {
    $patient->id = $data->id;
    $patient->name = $data->name;
    $patient->address = $data->address;
    $patient->conditions = $data->conditions;
    $patient->diagnosis = $data->diagnosis;

    if ($patient->update()) {
        echo json_encode(["message" => "Patient updated successfully."]);
    } else {
        echo json_encode(["message" => "Unable to update patient."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
