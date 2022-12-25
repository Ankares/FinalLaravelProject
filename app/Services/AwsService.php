<?php

namespace App\Services;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Aws\Ses\SesClient;
use Illuminate\Support\Facades\Log;

class AwsService
{
    public function __construct(
        private readonly S3Client $s3,
        private readonly SesClient $ses,
    ) {
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
            Log::info("Bucket: $bucketName successfully created");
        } catch (AwsException $e) {
            Log::error("Bucket was not created. Error message: " . $e->getAwsErrorMessage());
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
        try {
            $params = [
                'Bucket' => $bucketName,
                'Key' => $keyFile,
                'Body' => $body,
            ];
            $result = $this->s3->putObject($params);
            $command = $this->s3->getCommand('PutObject', $params);
            $result = $this->s3->execute($command);

            Log::info("File: $keyFile successfully exported into bucket: $bucketName");
        } catch (AwsException $e) {
            Log::error("File was not exported. Error message: " . $e->getAwsErrorMessage());
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
    private function getContentOfFiles($bucketName, $keyFile)
    {
        $fileData = '';
        $data = fopen(config('services.s3.endpoint') . '/' . $bucketName . '/' . $keyFile, 'r');
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
    private function getBucketInfo($bucketName)
    {
        $bucket = @simplexml_load_file(config('services.s3.endpoint') . '/' . $bucketName);
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
        $body = 'You have successfully uploaded file to AWS';
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
            Log::info("Email sent! Message ID : $messageId");
        } catch (AwsException $e) {
            Log::error("The email was not sent. Error message: " . $e->getAwsErrorMessage());
        }
    }

    /**
     * Displaying all the bucket's data
     *
     * @param string $bucketName
     *
     * @return array
     */
    public function displayingAWSContent($bucketName)
    {
        $bucketData = $this->getBucketInfo($bucketName);
        if ($bucketData != null) {
            foreach ($bucketData->Contents as $content) {
                $filesData[] = $this->getContentOfFiles($bucketName, $content->Key);
            }
        }

        return [
            'filesData' => $filesData ?? null,
            'bucketData' => $bucketData ?? null,
        ];
    }
}
