<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSeller
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'seller') {
            abort(403, 'Hanya seller yang boleh mengelola produk.');
        }

        return $next($request);
    }
}
