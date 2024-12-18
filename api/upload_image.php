<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

include_once '../includes/Database.php';
include_once '../includes/Image.php';
include_once '../aws_config.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && isset($_POST['category']) && isset($_POST['uploaded_by'])) {
        $imageFile = $_FILES['image'];
        $category = $_POST['category'];
        $uploadedBy = $_POST['uploaded_by'];

        $database = new Database();
        $db = $database->getConnection();

        $s3Client = S3ClientConfig::getS3Client();

        $bucketName = 'msc-project-healthcare-system';
        $key = 'images/' . basename($imageFile['name']);
        $filePath = $imageFile['tmp_name'];

        try {
            $result = $s3Client->putObject([
                'Bucket' => $bucketName,
                'Key' => $key,
                'SourceFile' => $filePath,
                'ACL' => 'public-read', // Optional, for public access
            ]);

            $image = new Image($db);
            $image->image_name = $imageFile['name'];
            $image->category = $category;
            $image->s3_url = $result['ObjectURL'];
            $image->uploaded_by = $uploadedBy;
            $image->uploaded_at = date('Y-m-d H:i:s');

            if ($image->uploadImage()) {
                echo json_encode(["message" => "Image uploaded successfully.", "url" => $result['ObjectURL']]);
            } else {
                echo json_encode(["message" => "Failed to save image details."]);
            }
        } catch (Exception $e) {
            echo json_encode(["message" => "Error uploading image to S3.", "error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} else {
    echo json_encode(["message" => "Invalid request method."]);
}
?>
