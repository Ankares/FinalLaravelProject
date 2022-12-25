<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    /**
     * Authorization via google services
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function googleAuth()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Google authorization callback
     *
     * @param \App\Repositories\UserRepository $userRepository
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function googleAuthCallback(UserRepository $userRepository)
    {
        $googleUser = Socialite::driver('google')->user();
        $user = $userRepository->updateOrCreateGoogleUser($googleUser);
        $roleOfTheUser = $userRepository->selectUsersRole($user);
        if (!isset($roleOfTheUser)) {
            $userRepository->addRoleToUser($user);
        }
        Auth::login($user);

        return redirect('/dashboard');
    }
}
