<?php

namespace App\Providers;

use App\Interfaces\CurrencyServiceInterface;
use App\Services\ExchangeCurrencyService;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    private const CURRENCIESURL = 'https://bankdabrabyt.by/export_courses.php';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurrencyServiceInterface::class, function ($app) {
            return new ExchangeCurrencyService(self::CURRENCIESURL);
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
