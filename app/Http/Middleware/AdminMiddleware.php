<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Prüfe, ob der Benutzer über den Admin-Guard authentifiziert ist
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
