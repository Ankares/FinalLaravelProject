<?php

namespace App\Repositories;

use App\Interfaces\UserDataInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserDataInterface
{
    public function updateOrCreateGoogleUser($googleUser)
    {
        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_token' => $googleUser->token,
        ]);

        return $user;
    }

    public function selectUsersRole($user)
    {
        $roleOfTheUser = DB::table('users_roles')->where('user_id', $user->id)->first();

        return $roleOfTheUser;
    }

    public function addRoleToUser($user)
    {
        $userRole = Role::where('slug', 'simple-user')->first();
        $user->roles()->attach($userRole);
    }
}
