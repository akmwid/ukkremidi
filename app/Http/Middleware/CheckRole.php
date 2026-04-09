<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (session('role') !== $role) {
            return redirect('/login')->with('error', 'Silahkan login terlebih dahulu.');
        }
        return $next($request);
    }
}
