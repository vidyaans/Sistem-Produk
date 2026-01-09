@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/tambah-edit-produk.css') }}">

<div class="tambah-produk-card">
    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="tambah-produk-header">
        <h3>Edit Kategori</h3>
    </div>

    <form action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST" id="form-edit-kategori">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" 
                name="nama_kategori" 
                id="nama_kategori" 
                value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                class="form-control @error('nama_kategori') is-invalid @enderror" 
                placeholder="Contoh: Elektronik" 
                required>

            @error('nama_kategori')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Deskripsi Kategori</label>
            <textarea name="deskripsi" 
                id="deskripsi"
                class="form-control @error('deskripsi') is-invalid @enderror" 
                rows="5" 
                placeholder="Tuliskan deskripsi kategori...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>

            @error('deskripsi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="tambah-produk-actions">
            <a href="{{ route('kategori.index') }}" class="btn-kembali-form">Kembali</a>
            <button type="submit" class="btn-simpan-produk">Update Kategori</button>
        </div>

    </form>

</div>

@endsection

@push('scripts')
<script>
    document.getElementById('form-edit-kategori').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Memperbarui kategori...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        setTimeout(() => {
            this.submit();
        }, 500);
    });
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonColor: '{{ session("role") === "superadmin" ? "#da915eff" : "#9ba377ff" }}',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}',
            confirmButtonColor: '#DC2626',
            showConfirmButton: true
        });
    });
</script>
@endif
@endpush