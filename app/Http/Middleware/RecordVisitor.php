<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;

class RecordVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $today = now()->toDateString();

        if (!Visitor::where('ip_address', $ip)->where('date', $today)->exists()) {
            Visitor::create([
                'ip_address' => $ip,
                'date' => $today
            ]);
        }

        return $next($request);
    }
}
