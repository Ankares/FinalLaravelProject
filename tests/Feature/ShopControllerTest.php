<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopControllerTest extends TestCase
{
    // use RefreshDatabase;

    public function test_create_and_store_methods()
    {
        $admin = new Role();
        $admin->name = 'Administrative user';
        $admin->slug = 'administrative-user';
        $admin->save();
        $adminRole = Role::where('slug', 'administrative-user')->first();

        $simpleUser = new Role();
        $simpleUser->name = 'Simple user';
        $simpleUser->slug = 'simple-user';
        $simpleUser->save();
        $userRole = Role::where('slug', 'simple-user')->first();

        $admin = User::factory()->createOne();
        $admin->roles()->attach($adminRole);
        $user = User::factory()->createOne();
        $user->roles()->attach($userRole);

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/add-product');
        $response->assertStatus(403);
        $response = $this->actingAs($admin)->withSession(['banned' => false])->get('/add-product');
        $response->assertStatus(200);

        $response = $this->post('/add-product', [
            'itemName' => 'Testing',
            'price' => null,
            'year' => 'wrong',
            'itemSetupCost' => '1000',
        ]);
        $response->assertInvalid();

        $response = $this->post('/add-product', [
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
        $response->assertValid();
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_show_method()
    {
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('TestManufacturer', false);
    }

    public function test_edit_and_update_methods()
    {
        $admin = new Role();
        $admin->name = 'Administrative user';
        $admin->slug = 'administrative-user';
        $admin->save();
        $adminRole = Role::where('slug', 'administrative-user')->first();

        $simpleUser = new Role();
        $simpleUser->name = 'Simple user';
        $simpleUser->slug = 'simple-user';
        $simpleUser->save();
        $userRole = Role::where('slug', 'simple-user')->first();

        $admin = User::factory()->createOne();
        $admin->roles()->attach($adminRole);
        $user = User::factory()->createOne();
        $user->roles()->attach($userRole);

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/add-product');
        $response->assertStatus(403);
        $response = $this->actingAs($admin)->withSession(['banned' => false])->get('/add-product');
        $response->assertStatus(200);

        $response = $this->post('/edit-product/7', [
            'itemName' => 'NewName',
            'price' => null,
        ]);
        $response->assertInvalid();

        $response = $this->post('/edit-product/7', [
            'itemName' => 'NewName',
            'manufacturer' => 'NewManufacturer',
            'year' => '2009',
            'price' => '2000',
        ]);
        $response->assertValid();
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_get_additional_services_and_cart_methods()
    {
        $admin = new Role();
        $admin->name = 'Administrative user';
        $admin->slug = 'administrative-user';
        $admin->save();
        $adminRole = Role::where('slug', 'administrative-user')->first();

        $simpleUser = new Role();
        $simpleUser->name = 'Simple user';
        $simpleUser->slug = 'simple-user';
        $simpleUser->save();
        $userRole = Role::where('slug', 'simple-user')->first();

        $admin = User::factory()->createOne();
        $admin->roles()->attach($adminRole);
        $user = User::factory()->createOne();
        $user->roles()->attach($userRole);

        $response = $this->actingAs($admin)->withSession(['banned' => false])->get('/product-services/7');
        $response->assertStatus(403);
        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/product-services/7');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->withSession(['banned' => false])->get('/shopping-cart');
        $response->assertStatus(403);
        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/shopping-cart');
        $response->assertStatus(200);
    }

    public function test_post_and_delete_from_cart_methods()
    {
        $admin = new Role();
        $admin->name = 'Administrative user';
        $admin->slug = 'administrative-user';
        $admin->save();
        $adminRole = Role::where('slug', 'administrative-user')->first();

        $simpleUser = new Role();
        $simpleUser->name = 'Simple user';
        $simpleUser->slug = 'simple-user';
        $simpleUser->save();
        $userRole = Role::where('slug', 'simple-user')->first();

        $admin = User::factory()->createOne();
        $admin->roles()->attach($adminRole);
        $user = User::factory()->createOne();
        $user->roles()->attach($userRole);

        $response = $this->actingAs($admin)->withSession(['banned' => false])->post('/shopping-cart', [
            'itemId' => '7',
            'itemName' => 'NewName',
        ]);
        $response->assertStatus(403);
        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/shopping-cart', [
            'itemId' => '7',
            'itemName' => 'NewName',
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->withSession(['banned' => false])->post('/shopping-cart/delete/7');
        $response->assertStatus(403);
        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/shopping-cart/delete/7');
        $response->assertStatus(302);
        $response->assertRedirect('/shopping-cart');
    }

    public function test_delete_product_method()
    {
        $admin = new Role();
        $admin->name = 'Administrative user';
        $admin->slug = 'administrative-user';
        $admin->save();
        $adminRole = Role::where('slug', 'administrative-user')->first();

        $simpleUser = new Role();
        $simpleUser->name = 'Simple user';
        $simpleUser->slug = 'simple-user';
        $simpleUser->save();
        $userRole = Role::where('slug', 'simple-user')->first();

        $admin = User::factory()->createOne();
        $admin->roles()->attach($adminRole);
        $user = User::factory()->createOne();
        $user->roles()->attach($userRole);

        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/delete-product/7');
        $response->assertStatus(403);
        $response = $this->actingAs($admin)->withSession(['banned' => false])->post('/delete-product/7');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
