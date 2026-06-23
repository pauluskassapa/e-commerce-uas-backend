<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsBuyer
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'buyer') {
            abort(403, 'Hanya buyer yang boleh memakai fitur keranjang.');
        }

        return $next($request);
    }
}
