<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // STEP 1: Cek login
        if (! Auth::check()) {  // ✅ ganti auth()->check() menjadi Auth::check()
            return redirect()->route('login');
        }

        // STEP 2: Cek apakah user adalah admin
        if (Auth::user()->role !== 'admin') {  // ✅ ganti auth()->user() menjadi Auth::user()
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // STEP 3: Lanjutkan request ke controller
        return $next($request);
    }
}
