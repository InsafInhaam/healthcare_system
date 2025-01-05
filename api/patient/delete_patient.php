<?php

header("Content-Type: application/json");
include_once '../includes/Database.php';
include_once '../includes/Patient.php';

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $patient->id = $data->id;

    if ($patient->delete()) {
        echo json_encode(["message" => "Patient deleted successfully."]);
    } else {
        echo json_encode(["message" => "Unable to delete patient."]);
    }
} else {
    echo json_encode(["message" => "Patient ID is required."]);
}
