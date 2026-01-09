<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;

class DashboardController extends Controller
{
    // =========================
    // HALAMAN DASHBOARD ADMIN
    // =========================
    public function index()
    {
        // Ambil ID admin yang sedang login dari session
        $adminId = session('admin_id');

        // Hitung total produk milik admin
        $totalProduk = Produk::where('admin_id', $adminId)->count();

        // Hitung total kategori milik admin
        $totalKategori = Kategori::where('admin_id', $adminId)->count();

        // Ambil daftar produk dengan stok hampir habis
        $hampirHabis = Produk::where('admin_id', $adminId)
            ->where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->get();

        // Kirim data ke view dashboard
        return view('dashboard.index', compact(
            'totalProduk',
            'totalKategori',
            'hampirHabis'
        ));
    }
}
