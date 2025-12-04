<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClienteAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth('cliente')->check()) {
            return redirect()->route('cliente.loginView');
        }
        return $next($request);
    }
}
