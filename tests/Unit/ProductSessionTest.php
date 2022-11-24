<?php

namespace Tests\Unit;

use App\Repositories\ShopRepository;
use App\Services\ShopSessionsService;
use App\Models\Shop;
use Tests\TestCase;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEmpty;

class ProductSessionTest extends TestCase
{
    public function test_session_service_methods()
    {
        $repositoryMock = $this->mock(ShopRepository::class);
        $repositoryMock->expects()->getOneProductById(1)->andReturn([[
            'id' => '1',
            'itemName' => 'TestItem',
            'manufacturer' => 'TestManufacturer',
            'itemCost' => '2000',
            'itemImage' => 'noimage.jpg',
            'created_year' => '2020',
            'warrantyPeriod' => '10 days',
            'warrantyCost' => '1000',
            'deliveryPeriod' => '10 days',
            'deliveryCost' => '1000',
            'itemSetupCost' => '1000',
        ]]);

        $modelMock = $this->mock(Shop::class);
        $modelMock->expects()->setData()->with(['itemId' => '1', 'warranty' => 'on']);
        $modelMock->expects()->getData()->andReturn(['itemId' => '1', 'warranty' => 'on']);
        $productService = new ShopSessionsService($modelMock, $repositoryMock);

        $productService->addProductToSession(['itemId' => '1', 'warranty' => 'on']);
        assertNotEmpty(session('products'));

        $returnArray = $productService->getProductsFromSession();
        $expectedArray = [
            ['id' => '1',
                'itemName' => 'TestItem',
                'itemImage' => 'noimage.jpg',
                'year' => '2020',
                'totalPrice' => '3000',
                'warrantyPeriod' => '10 days',
                'warrantyCost' => '1000', ],
        ];
        assertEquals($expectedArray, $returnArray);

        $productService->deleteFromSession(1);
        assertEmpty(session('products'));
    }
}
