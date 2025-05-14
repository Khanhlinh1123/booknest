<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;


use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\DanhMuc;

class SocialController extends Controller
{
    public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    $user = Socialite::driver('google')->user();

    // Xử lý logic đăng nhập hoặc đăng ký
}
}







