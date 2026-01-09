    @extends('layouts.app')

    @section('content')
    <link rel="stylesheet" href="{{ asset('css/detail-produk.css') }}">

    <div class="detail-produk-card">

        <div class="detail-produk-header">
            <h3>Detail Produk</h3>
        </div>

        <div class="detail-produk-image-box">
            @if ($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}">
            @else
                <img src="https://via.placeholder.com/400x250?text=No+Image" alt="No Image">
            @endif
        </div>

        <h4 class="detail-produk-title">{{ $produk->nama_produk }}</h4>

        <p class="detail-produk-kategori">{{ $produk->kategori->nama_kategori ?? '-' }}</p>

        <div class="detail-produk-info">
            <p><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
            <p>
                <strong>Stok:</strong> 
                <span class="stok-badge {{ $produk->stok <= 5 ? 'low' : '' }}">{{ $produk->stok }}</span>
            </p>
        </div>

        @if($produk->deskripsi)
        <div class="detail-produk-deskripsi">
            <strong>Deskripsi Produk:</strong>
            <p>{{ $produk->deskripsi }}</p>
        </div>
        @endif

        <div class="detail-produk-dates">
            <p><strong>Tanggal Ditambahkan:</strong> {{ $produk->created_at->format('d F Y') }}</p>
            <p><strong>Tanggal Diperbarui:</strong> {{ $produk->updated_at->format('d F Y') }}</p>
        </div>

        <div class="detail-produk-actions">

            <div class="detail-produk-left">
                <a href="{{ route('produk.index') }}" class="btn-kembali">Kembali</a>
            </div>

            <div class="detail-produk-right">
                <a href="{{ route('produk.edit', $produk->produk_id) }}" class="btn-edit-custom">Edit</a>

                <form action="{{ route('produk.destroy', $produk->produk_id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-hapus-custom">Hapus</button>
                </form>
            </div>

        </div>
    </div>

    @endsection