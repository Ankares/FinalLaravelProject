<?php

namespace App\Interfaces;

interface UserDataInterface
{
    public function updateOrCreateGoogleUser($googleUser);
    public function selectUsersRole($user);
    public function addRoleToUser($user);
}
