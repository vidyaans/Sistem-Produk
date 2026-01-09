@extends('layouts.app')

@section('title', 'Detail Akun Admin | AISTOPHILE MANAGEMENT')

@section('content')
<link rel="stylesheet" href="{{ asset('css/superadmin.css') }}">

<div class="detail-admin-container">

    <div class="detail-admin-card">

        <div class="detail-admin-header">
            <h3>{{ $admin->username }}</h3>
            <span class="status-{{ $admin->is_active ? 'aktif' : 'nonaktif' }}">
                {{ $admin->is_active ? 'Aktif' : 'Tidak Aktif' }}
            </span>
        </div>

        <div class="summary-cards-grid">

            <div class="summary-card-box">
                <div class="summary-header">Total Produk</div>
                <div class="summary-body">
                    <div class="summary-number">{{ $totalProduk }}</div>
                    <a href="{{ route('superadmin.admin.produk', $admin->id) }}" class="btn-lihat-detail">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <div class="summary-card-box">
                <div class="summary-header">Total Kategori</div>
                <div class="summary-body">
                    <div class="summary-number">{{ $totalKategori }}</div>
                    <a href="{{ route('superadmin.admin.kategori', $admin->id) }}" class="btn-lihat-detail">
                        Lihat Detail
                    </a>
                </div>
            </div>
            
        </div>

        <div class="detail-admin-actions">
            <a href="{{ route('superadmin.dashboard') }}" class="btn-kembali">Kembali</a>
            <a href="{{ route('superadmin.admin.edit', $admin->id) }}" class="btn-edit-admin">Edit Admin</a>
        </div>
        
    </div>
    
</div>

@endsection