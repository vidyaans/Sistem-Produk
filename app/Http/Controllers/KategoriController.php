<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // =========================
    // MENAMPILKAN DATA KATEGORI
    // =========================
    public function index()
    {
        // Ambil semua kategori milik admin yang login
        $kategoris = Kategori::where('admin_id', session('admin_id'))->get();
        return view('kategori.index', compact('kategoris'));
    }

    // =========================
    // FORM TAMBAH KATEGORI
    // =========================
    public function create()
    {
        return view('kategori.create');
    }

    // =========================
    // SIMPAN DATA KATEGORI BARU
    // =========================
    public function store(Request $request)
    {
        // Validasi input kategori
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        // Simpan data kategori ke database
        Kategori::create([
            'admin_id' => session('admin_id'),
            'nama_kategori' => $request->nama,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // =========================
    // DETAIL KATEGORI
    // =========================
    public function show(Kategori $kategori)
    {
        // Pastikan kategori milik admin yang login
        if ($kategori->admin_id !== session('admin_id')) {
            abort(403);
        }

        // Hitung total produk dalam kategori
        $totalProduk = Produk::where('kategori_id', $kategori->kategori_id)->count();

        return view('kategori.show', compact('kategori', 'totalProduk'));
    }

    // =========================
    // FORM EDIT KATEGORI
    // =========================
    public function edit(Kategori $kategori)
    {
        // Cek kepemilikan data kategori
        if ($kategori->admin_id !== session('admin_id')) {
            abort(403);
        }

        return view('kategori.edit', compact('kategori'));
    }

    // =========================
    // UPDATE DATA KATEGORI
    // =========================
    public function update(Request $request, Kategori $kategori)
    {
        // Cek kepemilikan kategori
        if ($kategori->admin_id !== session('admin_id')) {
            abort(403);
        }

        // Validasi input edit kategori
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        // Update data kategori
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    // =========================
    // HAPUS DATA KATEGORI
    // =========================
    public function destroy(Kategori $kategori)
    {
        // Pastikan kategori milik admin yang login
        if ($kategori->admin_id !== session('admin_id')) {
            abort(403);
        }

        // Hapus kategori dari database
        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
