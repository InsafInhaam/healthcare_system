<?php
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['diagnosis_report'])) {
        $id = $_POST['id'];
        $diagnosisReport = $_POST['diagnosis_report'];

        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE images SET diagnosis_report = :diagnosis_report WHERE id = :id");
        $stmt->execute(['diagnosis_report' => $diagnosisReport, 'id' => $id]);

        echo json_encode(['message' => 'Diagnosis report updated successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
