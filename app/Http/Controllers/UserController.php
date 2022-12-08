<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function googleAuth()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleAuthCallback(UserRepository $userRepository)
    {
        $googleUser = Socialite::driver('google')->user();
        $user = $userRepository->updateOrCreateGoogleUser($googleUser);
        $userExists = $userRepository->selectUsersRole($user);
        if (!isset($userExists)) {
            $userRepository->addRoleToUser($user);
        }
        Auth::login($user);

        return redirect('/dashboard');
    }
}
