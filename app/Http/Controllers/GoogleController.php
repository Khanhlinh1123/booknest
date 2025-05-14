<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

use Illuminate\Http\Request;


use App\Models\NguoiDung;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = NguoiDung::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'tenND' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar(),
                'phanQuyen' => 'customer', // mặc định
            ]
        );

        Auth::login($user);

        return redirect('/'); // hoặc route('dashboard')
    }
}

