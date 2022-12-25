<?php

namespace App\Providers;

use Aws\S3\S3Client;
use Aws\Ses\SesClient;
use Illuminate\Support\ServiceProvider;

class AwsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(S3Client::class, function ($app) {
            return new S3Client([
                'version' => 'latest',
                'region' => config('services.s3.region'),
                'use_path_style_endpoint' => true,
                'endpoint' => config('services.s3.endpoint'),
                'credentials' => array(
                    'key' => config('services.s3.key'),
                    'secret' => config('services.s3.secret'),
                )]);
        });

        $this->app->bind(SesClient::class, function ($app) {
            return new SesClient([
                'version' => 'latest',
                'region' => config('services.ses.region'),
                'use_path_style_endpoint' => true,
                'endpoint' => config('services.ses.endpoint'),
                'credentials' => array(
                    'key' => config('services.ses.key'),
                    'secret' => config('services.ses.secret'),
                )]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
