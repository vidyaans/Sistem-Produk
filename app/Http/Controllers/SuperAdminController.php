<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // =========================
    // DASHBOARD SUPER ADMIN
    // =========================
    public function dashboard()
    {
        // Hitung total admin (tanpa super admin)
        $totalAdmin = Admin::where('role', 'admin')->count();

        // Ambil daftar admin
        $admins = Admin::where('role', 'admin')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('superadmin.dashboard', compact(
            'totalAdmin',
            'admins'
        ));
    }

    // =========================
    // DETAIL ADMIN
    // =========================
    public function showAdmin($id)
    {
        // Ambil data admin
        $admin = Admin::findOrFail($id);

        // Cegah akses ke akun super admin
        if ($admin->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard')
                ->with('error', 'Tidak bisa melihat detail Super Admin');
        }

        // Hitung total produk admin
        $totalProduk = Produk::where('admin_id', $id)->count();

        // Hitung total kategori admin
        $totalKategori = Kategori::where('admin_id', $id)->count();

        return view('superadmin.admin-detail', compact(
            'admin',
            'totalProduk',
            'totalKategori'
        ));
    }

    // =========================
    // TOGGLE STATUS ADMIN
    // =========================
    public function updateAdminStatus($id)
    {
        // Ambil data admin
        $admin = Admin::findOrFail($id);

        // Cegah perubahan status super admin
        if ($admin->role === 'superadmin') {
            return redirect()->back()
                ->with('error', 'Tidak bisa mengubah status Super Admin');
        }

        // Ubah status aktif / nonaktif
        $admin->is_active = !$admin->is_active;
        $admin->save();

        $status = $admin->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
            ->with('success', "Admin {$admin->username} berhasil {$status}");
    }

    // =========================
    // DAFTAR PRODUK ADMIN
    // =========================
    public function showAdminProduk(Request $request, $id)
    {
        // Ambil data admin
        $admin = Admin::findOrFail($id);

        // Query produk milik admin
        $query = Produk::where('admin_id', $id)
                       ->with('kategori');

        // Filter berdasarkan kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        $produks = $query->get();

        // Ambil kategori milik admin
        $kategoris = Kategori::where('admin_id', $id)->get();

        return view('superadmin.admin-produk', compact(
            'admin',
            'produks',
            'kategoris'
        ));
    }

    // =========================
    // DAFTAR KATEGORI ADMIN
    // =========================
    public function showAdminKategori($id)
    {
        // Ambil data admin
        $admin = Admin::findOrFail($id);

        // Ambil kategori milik admin
        $kategoris = Kategori::where('admin_id', $id)->get();

        return view('superadmin.admin-kategori', compact(
            'admin',
            'kategoris'
        ));
    }

    // =========================
    // FORM EDIT STATUS ADMIN
    // =========================
    public function editAdmin($id)
    {
        // Ambil data admin
        $admin = Admin::findOrFail($id);
        
        // Cegah edit super admin
        if ($admin->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard')
                ->with('error', 'Tidak bisa edit Super Admin');
        }
        
        return view('superadmin.admin-edit', compact('admin'));
    }

    // =========================
    // UPDATE STATUS ADMIN
    // =========================
    public function updateAdmin(Request $request, $id)
    {
        // Ambil data admin
        $admin = Admin::findOrFail($id);
        
        // Cegah update super admin
        if ($admin->role === 'superadmin') {
            return redirect()->back()
                ->with('error', 'Tidak bisa edit Super Admin');
        }
        
        // Validasi status admin
        $request->validate([
            'is_active' => 'required|boolean'
        ]);
        
        // Simpan perubahan status
        $admin->is_active = $request->is_active;
        $admin->save();
        
        $status = $admin->is_active ? 'Aktif' : 'Tidak Aktif';
        
        return redirect()->route('superadmin.dashboard')
            ->with(
                'success',
                "Status admin {$admin->username} berhasil diubah menjadi {$status}"
            );
    }
}
