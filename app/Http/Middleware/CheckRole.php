<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect('login');
        }
        
        // Cek apakah user memiliki salah satu role yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            // Redirect ke halaman sebelumnya
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        return $next($request);
    }
}