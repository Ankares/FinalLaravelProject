<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessToAddProductTest extends TestCase
{
    // use RefreshDatabase;

    public function test_add_product_accessible()
    {
        $admin = new Role();
        $admin->name = 'Administrative user';
        $admin->slug = 'administrative-user';
        $admin->save();
        $adminRole = Role::where('slug', 'administrative-user')->first();
        $user = User::factory()->createOne();
        $user->roles()->attach($adminRole);

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/add-product');
        $response->assertStatus(200);

        $response = $this->post('/add-product', [
            'id' => '1111',
            'itemName' => 'Testing',
            'manufacturer' => 'TestManufacturer',
            'price' => '1010',
            'itemImage' => null,
            'year' => '2020',
            'warrantyPeriod' => '10 days',
            'warrantyCost' => '1000',
            'deliveryPeriod' => '10 days',
            'deliveryCost' => '1000',
            'itemSetupCost' => '1000',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
