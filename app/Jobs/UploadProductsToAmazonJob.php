<?php

namespace App\Jobs;

use App\Services\AwsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadProductsToAmazonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private $bucket,
        private $fileName,
        private $fileDir
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AwsService $awsService)
    {
        $awsService->createCsvFileWithPrices($this->fileDir);
        $awsService->makeBucket($this->bucket);
        $awsService->putFileInBucket($this->bucket, $this->fileName, $this->fileDir);
        $awsService->sendEmail();  
    }
}
