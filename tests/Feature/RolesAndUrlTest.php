<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Role;
use App\Models\ShopItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolesAndUrlTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * @dataProvider adminRedirections
     */
    public function test_admin_redirect_expections($status, $redirectTo): void
    {
        ShopItem::factory(1)->create();
        $admin = new Role();
        $admin->name = 'Administrative user';
        $admin->slug = 'administrative-user';
        $admin->save();
        $adminRole = Role::where('slug', 'administrative-user')->first();
        $user = User::factory()->createOne();
        $user->roles()->attach($adminRole);

        $response = $this->actingAs($user)->withSession(['banned' => false])->get($redirectTo);
        $response->assertStatus($status);
    }

    /**
     * @dataProvider userRedirections
     */
    public function test_user_redirect_expections($status, $redirectTo): void
    {
        $admin = new Role();
        $admin->name = 'Simple user';
        $admin->slug = 'simple-user';
        $admin->save();
        $adminRole = Role::where('slug', 'simple-user')->first();
        $user = User::factory()->createOne();
        $user->roles()->attach($adminRole);

        $response = $this->actingAs($user)->withSession(['banned' => false])->get($redirectTo);
        $response->assertStatus($status);
    }

    public function adminRedirections(): array
    {
        return $redirection = [
            [200, '/'],
            [200, '/add-product'],
            [200, '/edit-product/1'],
            [405, '/delete-product/1'],
            [403, '/shopping-cart'],
            [405, '/shopping-cart/delete/1'],
            [403, '/product-services/1'],
        ];
    }

    public function userRedirections(): array
    {
        return $redirection = [
            [200, '/'],
            [403, '/add-product'],
            [403, '/edit-product/1'],
            [405, '/delete-product/1'],
            [200, '/shopping-cart'],
            [405, '/shopping-cart/delete/1'],
            [200, '/product-services/1'],
        ];
    }
}
