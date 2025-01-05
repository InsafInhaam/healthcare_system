<?php
require __DIR__ . '/../vendor/autoload.php';

use Aws\S3\S3Client;

function getS3Client() {
    return new S3Client([
        'region'  => 'eu-north-1',  // Change based on your region
        'version' => 'latest',
        'credentials' => [
            'key'    => 'AKIAVY2PG4Z3ICVBOCOW',
            'secret' => 'oyPiDN865uN7Gwlclz04SQlGTjUk5ztlt9aHKtVu',
        ],
    ]);
}

function getBucketName() {
    return 'msc-project-healthcare-system'; // Replace with your bucket name
}
