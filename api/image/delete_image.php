<?php
require '../../config/s3.php';
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT image_url FROM images WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $image = $stmt->fetch();

        if ($image) {
            $imageUrl = $image['image_url'];
            $key = basename(parse_url($imageUrl, PHP_URL_PATH));

            $s3Client = getS3Client();
            $bucket = getBucketName();

            try {
                $s3Client->deleteObject([
                    'Bucket' => $bucket,
                    'Key'    => 'images/' . $key,
                ]);

                $stmt = $pdo->prepare("DELETE FROM images WHERE id = :id");
                $stmt->execute(['id' => $id]);

                echo json_encode(['message' => 'Image deleted successfully']);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Image not found']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
