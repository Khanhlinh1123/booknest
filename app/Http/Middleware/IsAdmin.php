<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->phanQuyen === 'admin') {
            return $next($request);
        }

        return response('🚫 Bạn không có quyền truy cập. Quyền hiện tại: ' . ($user->phanQuyen ?? 'null'), 403);
    }


}
