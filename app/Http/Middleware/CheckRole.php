<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN BARIS INI

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Kode ini sekarang akan berjalan tanpa error
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }

        return $next($request);
    }
}