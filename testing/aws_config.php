<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class S3ClientConfig
{
    private static $client;

    public static function getS3Client()
    {
        // Ensure you pass a valid region string here
        if (self::$client === null) {
            self::$client = new S3Client([
                'version' => 'latest',
                'region'  => 'eu-north-1', // Set the correct region here as a string
                'credentials' => [
                    'key'    => 'AKIAVY2PG4Z3ICVBOCOW',
                    'secret' => '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',
                ]
            ]);
        }

        return self::$client;
    }
}
?>
