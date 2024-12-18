<?php
include_once '../../includes/Database.php';
include_once '../../includes/Staff.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();

$staff = new Staff($db);
$stmt = $staff->readAll();

if ($stmt->rowCount() > 0) {
    $staff_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $staff_arr[] = $row;
    }
    echo json_encode($staff_arr);
} else {
    echo json_encode(array("message" => "No staff found."));
}
?>
