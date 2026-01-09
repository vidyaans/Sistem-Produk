<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Menentukan tabel dan primary key
    protected $table = 'kategoris';
    protected $primaryKey = 'kategori_id';

    // Field yang boleh diisi
    protected $fillable = [
        'admin_id',
        'nama_kategori',
        'deskripsi'
    ];

    // Relasi ke admin pemilik kategori
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Relasi ke produk dalam kategori
    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
