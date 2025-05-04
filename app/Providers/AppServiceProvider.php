<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\DanhMuc;
use App\Models\GioHang;
use App\Models\GioHangSach;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        View::composer('header', function ($view) {
            $view->with('danhmucs', DanhMuc::all());
        });
        View::composer('*', function ($view) {
            $soLuongTrongGio = 0;
    
            if (Auth::check()) {
                $gioHang = GioHang::where('maND', Auth::id())->first();
    
                if ($gioHang) {
                    $soLuongTrongGio = GioHangSach::where('maGH', $gioHang->maGH)->sum('soLuong');
                }
            } else {
                $sessionCart = session()->get('cart', []);
                $soLuongTrongGio = array_sum($sessionCart);
            }
    
            $view->with('soLuongTrongGio', $soLuongTrongGio);
        });
    }
}
