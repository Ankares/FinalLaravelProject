<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AMQPServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AMQPStreamConnection::class, function ($app) {
            return new AMQPStreamConnection(
                config('queue.connections.rabbitMQ.host'),
                config('queue.connections.rabbitMQ.port'),
                config('queue.connections.rabbitMQ.user'),
                config('queue.connections.rabbitMQ.password'),
            );
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
