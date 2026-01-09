<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // Menentukan tabel yang digunakan
    protected $table = 'admins';

    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'username',
        'password',
        'role',
        'is_active',
        'last_login'
    ];

    // Field yang disembunyikan saat serialization
    protected $hidden = [
        'password',
    ];

    // Casting tipe data atribut
    protected $casts = [
        'role' => 'string',
        'is_active' => 'boolean',
        'last_login' => 'datetime',
    ];

    // Cek apakah admin adalah Super Admin
    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    // Cek apakah admin adalah Admin biasa
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Cek apakah akun admin masih aktif
    public function isActive()
    {
        return $this->is_active == 1;
    }

    // Relasi ke tabel kategori
    public function kategoris()
    {
        return $this->hasMany(Kategori::class, 'admin_id');
    }

    // Relasi ke tabel produk
    public function produks()
    {
        return $this->hasMany(Produk::class, 'admin_id');
    }

    // Scope untuk mengambil admin yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // Scope untuk mengambil admin dengan role admin saja
    public function scopeOnlyAdmin($query)
    {
        return $query->where('role', 'admin');
    }
}
