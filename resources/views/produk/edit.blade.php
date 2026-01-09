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
        <h3>Edit Produk</h3>
    </div>

    <form action="{{ route('produk.update', $produk->produk_id) }}" method="POST" enctype="multipart/form-data" id="form-edit-produk">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" 
                name="nama_produk" 
                value="{{ old('nama_produk', $produk->nama_produk) }}"
                class="form-control @error('nama_produk') is-invalid @enderror" required>

            @error('nama_produk')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_id" 
                class="form-control @error('kategori_id') is-invalid @enderror" required>

                <option value="">--- Pilih Kategori ---</option>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->kategori_id }}" 
                        {{ old('kategori_id', $produk->kategori_id) == $k->kategori_id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>

            @error('kategori_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Jumlah Stok</label>
            <input type="number"
                name="stok"
                value="{{ old('stok', $produk->stok) }}"
                class="form-control @error('stok') is-invalid @enderror" required>

            @error('stok')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Harga Produk</label>
            <input type="number"
                name="harga"
                value="{{ old('harga', $produk->harga) }}"
                class="form-control @error('harga') is-invalid @enderror" required>

            @error('harga')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Gambar Produk</label>
            <input type="file" 
                name="gambar" 
                class="form-control @error('gambar') is-invalid @enderror"
                accept="image/*">

            <div class="format-info">Format: JPG, PNG, JPEG (maks 2MB)</div>

            @error('gambar')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror

            @if($produk->gambar)
                <img id="preview"
                    src="{{ asset('images/'.$produk->gambar) }}"
                    onerror="this.src='{{ asset('images/no-image.png') }}'"
                    style="margin-top:10px; max-height:150px; border-radius:6px;">
            @else
                <img id="preview"
                    src="{{ asset('images/no-image.png') }}"
                    style="margin-top:10px; max-height:150px; border-radius:6px;">
            @endif
        </div>

        <div class="mb-3">
            <label>Deskripsi Produk</label>
            <textarea name="deskripsi"
                class="form-control @error('deskripsi') is-invalid @enderror"
                rows="5">{{ old('deskripsi', $produk->deskripsi) }}</textarea>

            @error('deskripsi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="tambah-produk-actions">
            <a href="{{ route('produk.index') }}" class="btn-kembali-form">Kembali</a>
            <button type="submit" class="btn-simpan-produk">Update Produk</button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    document.querySelector('input[name="gambar"]').addEventListener('change', function(e){
        const img = document.getElementById('preview');
        if(e.target.files && e.target.files[0]) {
            img.src = URL.createObjectURL(e.target.files[0]);
            img.style.display = 'block';
        }
    });

    document.getElementById('form-edit-produk').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Memperbarui produk...',
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
@endpush