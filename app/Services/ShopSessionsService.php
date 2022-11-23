<?php

namespace App\Services;

use App\Models\Shop;
use App\Repositories\ShopRepository;

class ShopSessionsService
{
    public function __construct(
        private Shop $shopModel,
        private ShopRepository $shopRepository
    ) {
    }

    /**
     * Adding chosen product and its services to Session
     * 
     * @param array $chosenProductAndServices
     * 
     * @return void
     */
    public function addProductToSession($chosenProductAndServices)
    {
        $productExists = false;

        $this->shopModel->setData($chosenProductAndServices);
        $chosenData = $this->shopModel->getData();

        if (!session()->has('products')) {
            session()->push('products', $chosenData);

            return;
        }

        foreach (session('products') as $oneProduct) {
            if ($oneProduct && $oneProduct['itemId'] == $chosenProductAndServices['itemId']) {
                $productExists = true;

                break;
            }
        }

        if (false === $productExists) {
            session()->push('products', $chosenData);
        }
    }

    /**
     * Get chosen product and its services from Session
     * 
     * @return void|array
     */
    public function getProductsFromSession()
    {
        $productsWithChosenServices = [];

        if (!session()->has('products')) {
            return;
        }

        foreach (session('products') as $sessionProduct) {
            if (!$sessionProduct) {
                return;
            }

            $productIdInSession = $sessionProduct['itemId'];
            $productFromDB = $this->shopRepository->getOneProductById($productIdInSession);
            $productsWithChosenServices[] = $this->createArrayWithSelectedServices($productFromDB[0], $sessionProduct);
        }

        return $productsWithChosenServices;
    }

    /**
     * Creating an array of products with only chosen services 
     * 
     * @param array $productFromDB
     * @param array $sessionProduct
     * 
     * @return void|array
     */
    private function createArrayWithSelectedServices($productFromDB, $sessionProduct)
    {
        if ($productFromDB['id'] != $sessionProduct['itemId']) {
            return;
        }

        $productWithChosenServices = [];
        $totalPrice = $productFromDB['itemCost'];

        if (!empty($sessionProduct['warranty'])) {
            $totalPrice += $productFromDB['warrantyCost'];
            $productWithChosenServices = [...$productWithChosenServices, 'warrantyPeriod' => $productFromDB['warrantyPeriod'], 'warrantyCost' => $productFromDB['warrantyCost']];
        }
        if (!empty($sessionProduct['delivery'])) {
            $totalPrice += $productFromDB['deliveryCost'];
            $productWithChosenServices = [...$productWithChosenServices, 'deliveryPeriod' => $productFromDB['deliveryPeriod'], 'deliveryCost' => $productFromDB['deliveryCost']];
        }
        if (!empty($sessionProduct['setUp'])) {
            $totalPrice += $productFromDB['itemSetupCost'];
            $productWithChosenServices = [...$productWithChosenServices, 'setupCost' => $productFromDB['itemSetupCost']];
        }
        $productWithChosenServices = ['id' => $productFromDB['id'], 'itemName' => $productFromDB['itemName'], 'itemImage' => $productFromDB['itemImage'], 'year' => $productFromDB['created_year'], 'totalPrice' => $totalPrice, ...$productWithChosenServices, ];

        return $productWithChosenServices;
    }

    /**
     * Delete product from Session
     * 
     * @param int $id
     * 
     * @return void
     */
    public function deleteFromSession($id)
    {
        $session = session('products');
        session()->forget('products');

        foreach ($session as $sessionProduct) {
            if ($sessionProduct['itemId'] != $id) {
                session()->push('products', $sessionProduct);
            }
        }
    }
}
