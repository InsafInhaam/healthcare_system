<?php
include_once '../includes/Database.php';
include_once '../includes/Image.php';

header("Content-Type: application/json");

$id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(["message" => "Image ID is required"]));

$database = new Database();
$db = $database->getConnection();

$image = new Image($db);
$stmt = $image->getImageById($id);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode($row);
} else {
    echo json_encode(["message" => "Image not found."]);
}
?>
