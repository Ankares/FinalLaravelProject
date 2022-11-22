<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the users
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::where('slug', 'simple-user')->first();
        $adminRole = Role::where('slug', 'administrative-user')->first();

        $user = new User();
        $user->name = 'Artem Artem';
        $user->email = 'artem22@mail.ru';
        $user->password = password_hash('password', PASSWORD_DEFAULT);
        $user->save();
        $user->roles()->attach($userRole);

        $admin = new User();
        $admin->name = 'Administrator';
        $admin->email = 'admin@mail.ru';
        $admin->password = password_hash('password', PASSWORD_DEFAULT);
        $admin->save();
        $admin->roles()->attach($adminRole);
        
    }
   
}