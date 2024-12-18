<?php
include_once '../includes/Database.php';
include_once '../includes/Image.php';

header("Content-Type: application/json");

$database = new Database();
$db = $database->getConnection();

$image = new Image($db);
$stmt = $image->getAllImages();
$num = $stmt->rowCount();

if ($num > 0) {
    $images = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $images[] = [
            "id" => $id,
            "image_name" => $image_name,
            "category" => $category,
            "s3_url" => $s3_url,
            "uploaded_by" => $uploaded_by,
            "uploaded_at" => $uploaded_at,
        ];
    }
    echo json_encode($images);
} else {
    echo json_encode(["message" => "No images found."]);
}
?>
