<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Log;

class RabbitMQService
{
    private $bucketName = null;
    private $fileName = null;

    public function __construct(
        private readonly AMQPStreamConnection $rabbitMQ,
        private readonly AwsService $awsService,
    ) {
    }

     /**
     * Put a message in the queue in RabbitMQ
     *
     * @return void
     */
    public function sendMessageToRabbitMQ($message, $queueName)
    {
        $channel = $this->rabbitMQ->channel();

        $channel->queue_declare($queueName, false, false, false, false);

        $messageToPublish = new AMQPMessage(json_encode($message), array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($messageToPublish, '', $queueName);

        Log::info("Successfully sent message: $messageToPublish->body" . "to queue: " . $queueName);

        $channel->close();
    }

     /**
     * Put a trigger message in the queue to cancel consume
     *
     * @return void
     */
    private function sendTriggerToCancelConsume($queueName)
    {
        $channel = $this->rabbitMQ->channel();

        $channel->queue_declare($queueName, false, false, false, false);
        $message = new AMQPMessage('endpoint', array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($message, '', $queueName);

        $channel->close();
    }

     /**
     * Listen all messages in the queue and upload them to AWS
     *
     * @return void|null
     */
    public function listenFilesAndUploadToAWS($bucketName, $fileName, $queueName)
    {
        $this->bucketName = $bucketName;
        $this->fileName = $fileName;

        $this->sendTriggerToCancelConsume($queueName);

        $channel = $this->rabbitMQ->channel();

        $channel->queue_declare($queueName, false, false, false, false);

        $this->awsService->makeBucket($bucketName);

        $callback = function ($message) {
            if ($message->body == 'endpoint') {
                $message->getChannel()->basic_cancel($message->getConsumerTag());

                return;
            }
            $pathToTheFile = json_decode($message->body);
            $fileContent = file_get_contents($pathToTheFile);
            file_put_contents($pathToTheFile, '');
            $this->awsService->putFileInBucket($this->bucketName, $this->fileName, $fileContent);
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->rabbitMQ->close();

        $this->awsService->sendEmail();
    }
}
