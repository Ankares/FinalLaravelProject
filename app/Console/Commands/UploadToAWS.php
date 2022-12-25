<?php

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Illuminate\Console\Command;

class UploadToAWS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aws:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command starts listening all messages from RabbitMQ, getting files by these messages and uploading all these files to AWS';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RabbitMQService $rabbitService)
    {
        $rabbitService->listenFilesAndUploadToAWS('shop-bucket', 'prices', 'filePath');
        $this->info('The command was successful');
    }
}
