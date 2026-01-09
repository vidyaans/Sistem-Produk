<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // Menentukan tabel dan primary key
    protected $table = 'produks';
    protected $primaryKey = 'produk_id';

    // Field yang boleh diisi
    protected $fillable = [
        'admin_id',
        'toko_id',
        'kategori_id',
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'gambar'
    ];

    // Relasi ke admin pemilik produk
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Relasi ke kategori produk
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
