<?php

namespace Tests\Unit;

use App\Repositories\ShopRepository;
use App\Services\ShopSessionsService;
use App\Models\ShopItem;
use Illuminate\Contracts\Session\Session;
use Tests\TestCase;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEmpty;

class ProductSessionTest extends TestCase
{
    public function test_session_service_methods()
    {
        $repositoryMock = $this->mock(ShopRepository::class);
        $repositoryMock->expects()->getOneProductById(1)->andReturn([
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
        ]);

        $modelMock = $this->mock(ShopItem::class);
        $modelMock->expects()->setData()->with(['itemId' => '1', 'warranty' => 'on']);
        $modelMock->expects()->getData()->andReturn(['itemId' => '1', 'warranty' => 'on']);

        $sessionMock = $this->mock(Session::class);
        $sessionMock->expects()->has()->with('products');
        $sessionMock->expects()->has()->with('products')->andReturn('true');
        $sessionMock->expects()->push()->with('products', ['itemId' => '1', 'warranty' => 'on']);
        $sessionMock->expects()->get()->with('products')->andReturn([['itemId' => '1', 'warranty' => 'on']])->twice();
        $sessionMock->expects()->forget()->with('products');

        $productService = new ShopSessionsService($modelMock, $repositoryMock, $sessionMock);

        $productService->addProductToSession(['itemId' => '1', 'warranty' => 'on']);
        assertNotEmpty($sessionMock);

        $returnArray = $productService->getProductsFromSession();

        $expectedArray = [[
            'id' => '1',
            'itemName' => 'TestItem',
            'itemImage' => 'noimage.jpg',
            'year' => '2020',
            'totalPrice' => '3000',
            'warrantyPeriod' => '10 days',
            'warrantyCost' => '1000',
        ]];
        assertEquals($expectedArray, $returnArray);

        $productService->deleteFromSession(1);
        assertEmpty(session('products'));
    }
}
