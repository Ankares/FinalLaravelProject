<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Interfaces\CurrencyServiceInterface;

class ExchangeCurrencyService implements CurrencyServiceInterface
{
    public const TTL = 60;

    public function __construct(
        private readonly string $url
    ) {
       //
    }
    /**
     * Parse file with all currencies in Brest filial
     *
     * @return array
     */
    private function parseFileWithCurrencies(): array
    {
        $file = @simplexml_load_file($this->url);
        $brestRates = $file->filials->filial[1]->rates->value;

        foreach ($brestRates as $rate) {
            $requiredCurrencies[] = [
                'iso' => (string) $rate['iso'],
                'value' => (string) $rate['sale'],
            ];
        }

        return $requiredCurrencies;
    }

    /**
     * Making aside caching of currencies and return array with data
     *
     * @return array
     */
    public function getCurrencies(): array
    {
        if (Cache::store('redis')->has("currencies: $this->url")) {
            $data = Cache::store('redis')->get("currencies: $this->url");

            return $data;
        }

        $data = $this->parseFileWithCurrencies($this->url);
        Cache::store('redis')->put("currencies: $this->url", $data, self::TTL);

        return $data;
    }
}
