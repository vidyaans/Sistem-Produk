<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah admin sudah login
        if (!session()->has('admin_id')) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Batasi akses hanya untuk Super Admin
        if (session('role') !== 'superadmin') {
            abort(403, 'Unauthorized - Super Admin Only');
        }

        // Cek status akun Super Admin
        if (!session('is_active')) {
            session()->flush();
            return redirect('/login')
                ->with('error', 'Akun Anda telah dinonaktifkan');
        }

        // Lanjutkan request jika lolos semua pengecekan
        return $next($request);
    }
}
