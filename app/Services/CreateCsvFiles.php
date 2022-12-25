<?php

namespace App\Services;

use App\Repositories\ShopRepository;

class CreateCsvFiles
{
    public function __construct(
        private readonly ShopRepository $repository
    ) {
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
}
