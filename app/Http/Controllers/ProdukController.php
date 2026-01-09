<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // =========================
    // MENAMPILKAN DAFTAR PRODUK
    // =========================
    public function index(Request $request)
    {
        // Ambil kategori milik admin untuk filter
        $kategoris = Kategori::where('admin_id', session('admin_id'))->get();

        // Query dasar produk milik admin
        $query = Produk::where('admin_id', session('admin_id'));

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Pencarian berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Ambil data produk dengan relasi kategori dan pagination
        $produks = $query->with('kategori')
                         ->orderBy('kategori_id')
                         ->paginate(24)
                         ->withQueryString();

        // Kelompokkan produk berdasarkan kategori
        $produkPerKategori = $produks->groupBy('kategori_id');

        return view('produk.index', compact(
            'produks',
            'kategoris',
            'produkPerKategori'
        ));
    }

    // =========================
    // FORM TAMBAH PRODUK
    // =========================
    public function create()
    {
        // Ambil kategori milik admin
        $kategoris = Kategori::where('admin_id', session('admin_id'))->get();
        return view('produk.create', compact('kategoris'));
    }

    // =========================
    // SIMPAN PRODUK BARU
    // =========================
    public function store(Request $request)
    {
        // Validasi input produk
        $request->validate([
            'nama_produk' => 'required|max:100',
            'harga' => 'required|numeric|min:1000',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string|max:1000', 
        ]);

        // =========================
        // SIMPAN GAMBAR KE public/images
        // (NOTE: akan hilang saat redeploy Railway)
        // =========================
        $filename = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
        }

        // Simpan data produk ke database
        Produk::create([
            'admin_id' => session('admin_id'),
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $filename, // nama file gambar
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // =========================
    // FORM EDIT PRODUK
    // =========================
    public function edit(Produk $produk)
    {
        // Cek kepemilikan produk
        if ($produk->admin_id !== session('admin_id')) {
            abort(403);
        }

        // Ambil kategori milik admin
        $kategoris = Kategori::where('admin_id', session('admin_id'))->get();

        return view('produk.edit', compact('produk', 'kategoris'));
    }

    // =========================
    // UPDATE DATA PRODUK
    // =========================
    public function update(Request $request, Produk $produk)
    {
        // Validasi input edit produk
        $request->validate([
            'nama_produk' => 'required|max:100',
            'harga' => 'required|numeric|min:1000',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string|max:1000', 
        ]);

        // Data yang akan diperbarui
        $data = [
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi, 
        ];

        // =========================
        // UPDATE GAMBAR JIKA ADA UPLOAD BARU
        // =========================
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama jika ada
            if ($produk->gambar && file_exists(public_path('images/'.$produk->gambar))) {
                unlink(public_path('images/'.$produk->gambar));
            }

            // Simpan gambar baru
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $data['gambar'] = $filename;
        }

        // Update data produk
        $produk->update($data);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // =========================
    // DETAIL PRODUK
    // =========================
    public function show(Produk $produk)
    {
        // Pastikan produk milik admin yang login
        if ($produk->admin_id !== session('admin_id')) {
            abort(403);
        }

        return view('produk.show', compact('produk'));
    }

    // =========================
    // HAPUS PRODUK
    // =========================
    public function destroy(Produk $produk)
    {
        // Cek kepemilikan produk
        if ($produk->admin_id !== session('admin_id')) {
            abort(403);
        }

        // Hapus file gambar jika ada
        if ($produk->gambar && file_exists(public_path('images/'.$produk->gambar))) {
            unlink(public_path('images/'.$produk->gambar));
        }

        // Hapus data produk
        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
