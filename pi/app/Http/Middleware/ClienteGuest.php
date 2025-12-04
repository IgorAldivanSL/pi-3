<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteGuest
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('cliente')->check()) {
            return redirect()->route('cliente.dashboard');
        }

        return $next($request);
    }
}
