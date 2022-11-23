<?php

namespace Tests\Unit;

use App\Repositories\CarsRepository;
use App\Repositories\ShopRepository;
use App\Services\FileProcessingService;
use App\Services\ShopItemProcessingService;
use Illuminate\Http\Request;
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
        $requestMock = $this->mock(Request::class);
        $fileMock = $this->mock(FileProcessingService::class);

        $productService = new ShopItemProcessingService($fileMock, $repositoryMock);

        $requestMock->expects()->validate()->with(['itemName' => 'required|min:5|max:100',
        'manufacturer' => 'required|string|max:100',
        'price' => 'required|integer',
        'year' => 'required|integer|min:2000|max:2022',
        'itemImage' => 'nullable|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=300,min_height=300,max_width=2000,max_height=2000',
        'warrantyCost' => 'nullable|integer|max:2000',
        'deliveryCost' => 'nullable|integer|max:2000',
        'setUpCost' => 'nullable|integer|max:2000']);
        $requestMock->warrantyPeriod = 'no';
        $requestMock->deliveryPeriod ='no';
        $requestMock->dropImage = 'no';
        $requestMock->id = '1';

        $fileMock->expects()->imageStoring()->with($requestMock)->andReturn('noimage.jpg');

        $repositoryMock->expects()->addOneProduct($requestMock, 'noimage.jpg');
       
        $productService->storeProduct($requestMock);
        
    }

    public function test_update_product_method()
    {
        $repositoryMock = $this->mock(ShopRepository::class);
        $requestMock = $this->mock(Request::class);
        $fileMock = $this->mock(FileProcessingService::class);

        $productService = new ShopItemProcessingService($fileMock, $repositoryMock);

        $requestMock->expects()->validate()->with(['itemName' => 'required|min:5|max:100',
        'manufacturer' => 'required|string|max:100',
        'price' => 'required|integer',
        'year' => 'required|integer|min:2000|max:2022',
        'itemImage' => 'nullable|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=300,min_height=300,max_width=2000,max_height=2000',
        'warrantyCost' => 'nullable|integer|max:2000',
        'deliveryCost' => 'nullable|integer|max:2000',
        'setUpCost' => 'nullable|integer|max:2000']);
        $requestMock->warrantyPeriod = 'no';
        $requestMock->deliveryPeriod ='no';
        $requestMock->dropImage = null;
        $requestMock->id = '1';

        $repositoryMock->expects()->getOneProductById(1)->andReturn([['id' => '1',
        'itemName' => 'TestItem',
        'manufacturer' => 'TestManufacturer',
        'itemCost' => '2000',
        'itemImage' => 'noimage.jpg',
        'created_year' => '2020',
        'warrantyCost' => '1000',
        'deliveryCost' => '1000',
        'itemSetupCost' => '1000',
        'path' => 'noimage.jpg']]);

        $requestMock->expects()->hasFile()->with('itemImage')->andReturns(false);
        $fileMock->expects()->imageStoring()->with($requestMock)->andReturn('noimage.jpg');
               
        $repositoryMock->expects()->updateOneProduct($requestMock, 'noimage.jpg');
        $productService->updateProduct($requestMock);
    }

    public function test_delete_product_method()
    {
        $repositoryMock = $this->mock(ShopRepository::class);
        $requestMock = $this->mock(Request::class);
        $fileMock = $this->mock(FileProcessingService::class);

        $productService = new ShopItemProcessingService($fileMock, $repositoryMock);

        $repositoryMock->expects()->getOneProductById(1)->andReturn([[
        'id' => '1', 'itemImage' => 'noimage.jpg']]);
  
        $repositoryMock->expects()->deleteOneProduct($requestMock->id);
        $productService->deleteProduct($requestMock->id);
    }

}