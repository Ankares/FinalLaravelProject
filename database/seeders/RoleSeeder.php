<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     *  Seed the roles.
     *
     *  @return void
     */
    public function run()
    {
        $user = new Role();
        $user->name = 'Simple User';
        $user->slug = 'simple-user';
        $user->save();

        $admin = new Role();
        $admin->name = 'Administrative user';
        $admin->slug = 'administrative-user';
        $admin->save();
    }
}
