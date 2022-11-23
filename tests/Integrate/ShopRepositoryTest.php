<?php

namespace Tests\Integrate;

use App\Models\Shop;
use App\Repositories\ShopRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ShopRepositoryTest extends TestCase
{
    // use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_db_insert_select_work()
    {
        Shop::factory()->createOne([
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
        $db_data = DB::select('select * from shops where id = 1');
        $model_data = Shop::find($db_data[0]->id);
        $this->assertNotEmpty([$db_data, $model_data]);
        $this->assertEquals($db_data[0]->itemName, $model_data->itemName);
    }
    public function test_db_delete_work()
    {
        DB::delete('delete from shops where id = 1');
        $db_data = DB::select('select * from shops where id = 1');
        $this->assertEmpty($db_data);
        $this->assertCount(0, $db_data);
    }
}