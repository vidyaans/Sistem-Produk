<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // =========================
    // PROSES REGISTRASI ADMIN
    // =========================
    public function register(Request $request)
    {
        // Validasi input registrasi
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:admins,username|max:100',
            'password' => 'required|min:6|confirmed',
        ], [
            'username.unique' => 'Username sudah terdaftar',
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Jika validasi gagal, tampilkan pesan error
        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return back()->with([
                'sweetalert' => [
                    'type' => 'error',
                    'title' => 'Registrasi Gagal',
                    'text' => $errors[0]
                ]
            ])->withInput();
        }

        // Simpan data admin baru
        Admin::create([
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'role'       => 'admin',
            'is_active'  => 1,
        ]);

        // Redirect ke halaman login
        return redirect('/?page=login')->with([
            'sweetalert' => [
                'type' => 'success',
                'title' => 'Registrasi Berhasil!',
                'text' => "Akun {$request->username} berhasil dibuat. Silakan login."
            ]
        ]);
    }

    // =========================
    // PROSES LOGIN ADMIN
    // =========================
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Ambil data admin berdasarkan username
        $admin = Admin::where('username', $request->username)->first();

        // Jika username tidak ditemukan
        if (!$admin) {
            return back()->with([
                'sweetalert' => [
                    'type' => 'error',
                    'title' => 'Login Gagal',
                    'text' => 'Username tidak ditemukan'
                ]
            ]);
        }

        // Cek status akun admin
        if (!$admin->isActive()) {
            return back()->with([
                'sweetalert' => [
                    'type' => 'warning',
                    'title' => 'Akun Dinonaktifkan',
                    'text' => 'Akun Anda telah dinonaktifkan. Hubungi Super Admin.'
                ]
            ]);
        }

        // Verifikasi password
        if (!Hash::check($request->password, $admin->password)) {
            return back()->with([
                'sweetalert' => [
                    'type' => 'error',
                    'title' => 'Login Gagal',
                    'text' => 'Password salah'
                ]
            ]);
        }

        // Update waktu login terakhir
        $admin->last_login = now();
        $admin->save();

        // Simpan data ke session
        session([
            'admin_id'  => $admin->id,
            'username'  => $admin->username,
            'role'      => $admin->role,
            'is_active' => $admin->is_active
        ]);

        // Redirect sesuai role admin
        if ($admin->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard')->with([
                'sweetalert' => [
                    'type' => 'success',
                    'title' => 'Selamat Datang!',
                    'text' => "Login berhasil sebagai Super Admin: {$admin->username}"
                ]
            ]);
        }

        return redirect()->route('dashboard')->with([
            'sweetalert' => [
                'type' => 'success',
                'title' => 'Selamat Datang!',
                'text' => "Login berhasil sebagai {$admin->username}"
            ]
        ]);
    }

    // =========================
    // PROSES LOGOUT
    // =========================
    public function logout()
    {
        // Ambil username sebelum session dihapus
        $username = session('username');

        // Hapus seluruh session
        session()->flush();

        // Redirect ke halaman login
        return redirect('/?page=login')->with([
            'sweetalert' => [
                'type' => 'success',
                'title' => 'Logout Berhasil',
                'text' => "Sampai jumpa lagi, {$username}!"
            ]
        ]);
    }
}
