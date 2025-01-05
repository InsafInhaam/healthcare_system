<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

require '../../config/s3.php';
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'], $_POST['patient_id'], $_POST['image_type'], $_POST['disease_type'], $_POST['diagnosis_report'])) {
        $file = $_FILES['image'];
        $fileName = basename($file['name']);
        $fileTempPath = $file['tmp_name'];

        $patientId = $_POST['patient_id'];
        $imageType = $_POST['image_type'];
        $diseaseType = $_POST['disease_type'];
        $diagnosisReport = $_POST['diagnosis_report'];

        $s3Client = getS3Client();
        $bucket = getBucketName();

        try {
            // Upload file to S3
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'images/' . $fileName,
                'SourceFile' => $fileTempPath,
            ]);

            $url = $result['ObjectURL'];

            // Save file info in MySQL
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("INSERT INTO images (patient_id, image_type, disease_type, image_url, diagnosis_report) VALUES (:patient_id, :image_type, :disease_type, :image_url, :diagnosis_report)");
            $stmt->execute([
                'patient_id' => $patientId,
                'image_type' => $imageType,
                'disease_type' => $diseaseType,
                'image_url' => $url,
                'diagnosis_report' => $diagnosisReport
            ]);

            echo json_encode(['message' => 'Image uploaded successfully', 'url' => $url]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
