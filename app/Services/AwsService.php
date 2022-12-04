<?php

namespace App\Services;

use App\Repositories\ShopRepository;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Aws\Ses\SesClient;

class AwsService
{
    private $s3 = null;
    private $ses = null;

    public function __construct(
        private readonly ShopRepository $repository
    )
    {
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => $_ENV['AWS_DEFAULT_REGION'],
            'use_path_style_endpoint' => true,
            'endpoint' => $_ENV['AWS_ENDPOINT'],
            'credentials' => array(
                'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
            )]);

        $this->ses = new SesClient([
            'version' => 'latest',
            'region' => $_ENV['AWS_DEFAULT_REGION'],
            'use_path_style_endpoint' => true,
            'endpoint' => $_ENV['AWS_ENDPOINT'],
            'credentials' => array(
                'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
            )]);

    }

    /**
     * Creating csv file with products prices from DB
     * 
     * @param string $savePath
     * 
     * @return void
     */
    public function createCsvFileWithPrices($savePath)
    {
        $products = $this->repository->getProductsPrices();
        $fp = fopen($savePath, 'w');
        foreach ($products as $product) {
            fputcsv($fp, $product);
        }
        fclose($fp);
    }
    
    /**
     * Making bucket in AWS
     * 
     * @param string $bucketName
     * 
     * @return void
     */
    public function makeBucket($bucketName)
    {
        try {
            $result = $this->s3->createBucket([
                'Bucket' => $bucketName,
            ]);

            echo ("\n"."Bucket: $bucketName successfully created" . "\n");
        } catch (AwsException $e) {
            echo $e->getMessage();
            echo("Bucket was not created. Error message: ".$e->getAwsErrorMessage()."\n");
            echo "\n";
        }
    }

    /**
     * Put csv file to the bucket
     * 
     * @param string $bucketName
     * @param string $keyFile
     * @param string $body
     * 
     * @return void
     */
    public function putFileInBucket($bucketName, $keyFile, $body)
    {
        try{
            $params = [
                'Bucket' => $bucketName,
                'Key' => $keyFile,
                'Body' => $body,
            ];
            $result = $this->s3->putObject($params);
            $command = $this->s3->getCommand('PutObject', $params);
            $result = $this->s3->execute($command);

            echo ("File: $keyFile successfully exported into bucket: $bucketName" . "\n");
        } catch (AwsException $e) {
            echo $e->getMessage();
            echo("File was not exported. Error message: ".$e->getAwsErrorMessage()."\n");
            echo "\n";
        }
    }
   
    /**
     * Parse all files in the bucket
     * 
     * @param string $bucketName
     * @param string $keyFile
     * 
     * @return array
     */
    public function getContentOfFiles($bucketName, $keyFile)
    {
        $fileData = '';
        $data = fopen($_ENV['AWS_ENDPOINT'].'/'.$bucketName.'/'.$keyFile, 'r');
        while (!feof($data)) {
            $fileData .= fgets($data);
        }
        fclose($data);
        
        return [
            'fileName' => $keyFile,
            'fileContent' => $fileData,
        ];
    }

     /**
     * Get info about Bucket
     * 
     * @param string $bucketName
     * 
     * @return \SimpleXMLElement|null
     */
    public function getBucketInfo($bucketName)
    {
        $bucket = @simplexml_load_file($_ENV['AWS_ENDPOINT'].'/'.$bucketName);
        if ($bucket != null) {
            return $bucket;
        }
        
        return null;
    }

     /**
     * Sending email message about export status
     * 
     * @return void
     */
    public function sendEmail()
    {
        $senderEmail = 'artem@mail.com';
        $recipientEmail = 'example@mail.com';
        $subject = 'File upload';
        $body = 'You have successfully uploaded file';
        $charset = 'UTF-8';
        
        try {
            $result = $this->ses->sendEmail([
                'Destination' => [
                    'ToAddresses' => [$recipientEmail],
                ],
                'ReplyToAddresses' => [$senderEmail],
                'Source' => $senderEmail,
                'Message' => [
                    'Body' => [
                        'Text' => [
                            'Charset' => $charset,
                            'Data' => $body,
                        ],
                    ],
                    'Subject' => [
                        'Charset' => $charset,
                        'Data' => $subject,
                    ],
                ],
            ]);
            $messageId = $result['MessageId'];
            echo ("Email sent! Message ID : $messageId" . "\n");
        } catch (AwsException $e) {
            echo $e->getMessage();
            echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
            echo "\n";
        }
    }
}