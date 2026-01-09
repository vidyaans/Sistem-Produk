@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/tambah-edit-kategori.css') }}">

<div class="tambah-kategori-card">

    <div class="tambah-kategori-header">
        <h3>Tambah Kategori</h3>
    </div>

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Skincare" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi Kategori</label>
            <textarea name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan deskripsi kategori..."></textarea>
        </div>

        <div class="tambah-kategori-actions">
            <a href="{{ route('kategori.index') }}" class="btn-kembali-kategori">Kembali</a>
            <button type="submit" class="btn-simpan-kategori">Simpan Kategori</button>
        </div>

    </form>

</div>

@endsection