<?php
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM images");
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['images' => $images]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
