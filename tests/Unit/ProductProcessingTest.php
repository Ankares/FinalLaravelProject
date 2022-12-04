<?php

namespace Tests\Unit;

use App\Http\Requests\ShopItemStoreRequest;
use App\Repositories\ShopRepository;
use App\Services\FileProcessingService;
use App\Services\ShopItemProcessingService;
use Tests\TestCase;

class ProductProcessingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_instanse_exists()
    {
        $mock = $this->getMockBuilder('ShopItemProcessingService')->getMock();
        $this->assertInstanceOf('ShopItemProcessingService', $mock);
    }

    public function test_store_product_method()
    {
        $repositoryMock = $this->mock(ShopRepository::class);
        $requestMock = $this->mock(ShopItemStoreRequest::class);
        $fileMock = $this->mock(FileProcessingService::class);

        $productService = new ShopItemProcessingService($fileMock, $repositoryMock);

        $requestMock->warrantyPeriod = 'no';
        $requestMock->deliveryPeriod = 'no';
        $requestMock->dropImage = 'no';
        $requestMock->id = '1';

        $requestMock->expects()->file()->with('itemImage')->andReturn('itemImage');
        $fileMock->expects()->imageStoring()->with('itemImage')->andReturn('noimage.jpg');

        $repositoryMock->expects()->addOneProduct($requestMock, 'noimage.jpg');

        $productService->storeProduct($requestMock);
    }

    public function test_update_product_method()
    {
        $repositoryMock = $this->mock(ShopRepository::class);
        $requestMock = $this->mock(ShopItemStoreRequest::class);
        $fileMock = $this->mock(FileProcessingService::class);

        $productService = new ShopItemProcessingService($fileMock, $repositoryMock);

        $requestMock->warrantyPeriod = 'no';
        $requestMock->deliveryPeriod = 'no';
        $requestMock->itemImage = null;
        $requestMock->dropImage = null;
        $requestMock->id = '1';

        $repositoryMock->expects()->getOneProductById(1)->andReturn(['itemImage' => 'noimage.jpg']);
        $repositoryMock->expects()->updateOneProduct($requestMock, 'noimage.jpg');

        $productService->updateProduct($requestMock);
    }

    public function test_delete_product_method()
    {
        $repositoryMock = $this->mock(ShopRepository::class);
        $fileMock = $this->mock(FileProcessingService::class);

        $productService = new ShopItemProcessingService($fileMock, $repositoryMock);

        $repositoryMock->expects()->getOneProductById(1)->andReturn(['itemImage' => 'amazing.jpg']);

        $fileMock->expects()->deleteFromDir()->with('amazing.jpg');
        $fileMock->expects()->deleteEmptyDir()->with('amazing.jpg');

        $repositoryMock->expects()->deleteOneProduct(1);

        $productService->deleteProduct(1);
    }
}
