<?php
include_once '../../includes/Database.php';
require 'vendor/autoload.php';  // AWS SDK for PHP

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class ImageManager
{
    private $s3Client;
    private $bucket;
    private $db;

    public function __construct($db)
    {
        // Set up AWS S3 client
        $this->s3Client = new S3Client([
            'region' => 'us-west-1',  // Set your S3 bucket region
            'version' => 'latest',
            'credentials' => [
                'key'    => 'your-access-key-id',
                'secret' => 'your-secret-access-key',
            ]
        ]);
        $this->bucket = 'your-s3-bucket-name';
        $this->db = $db;
    }

    public function uploadImage($patient_id, $category, $file)
    {
        // Generate a unique filename
        $file_name = uniqid() . '-' . basename($file['name']);
        $file_tmp = $file['tmp_name'];

        // Upload to S3
        try {
            $result = $this->s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key'    => 'images/' . $file_name,
                'SourceFile' => $file_tmp,
                'ACL'    => 'public-read'  // Set the permissions
            ]);

            // Get the file URL from S3
            $file_url = $result['ObjectURL'];

            // Save metadata to the database
            $query = "INSERT INTO images (patient_id, category, file_name, file_url, upload_status) 
                      VALUES (:patient_id, :category, :file_name, :file_url, 'Uploaded')";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':file_name', $file_name);
            $stmt->bindParam(':file_url', $file_url);

            if ($stmt->execute()) {
                return json_encode(["message" => "Image uploaded successfully."]);
            } else {
                return json_encode(["message" => "Failed to save image metadata."]);
            }
        } catch (AwsException $e) {
            return json_encode(["message" => "Error uploading image to S3: " . $e->getMessage()]);
        }
    }
}
