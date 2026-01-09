@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/daftar-produk.css') }}">

<div class="produk-header">
    <h3>Daftar Produk</h3>
    <a href="{{ route('produk.create') }}" class="btn-tambah-produk">+ Tambah Produk</a>
</div>

<div class="filter-produk-card">
    <form action="{{ route('produk.index') }}" method="GET">
        
        <div class="filter-grid">

            <div class="filter-item">
                <label>Cari Nama Produk</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control" placeholder="Cari produk...">
            </div>

            <div class="filter-item">
                <label>Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    @foreach ($kategoris as $kat)
                        <option value="{{ $kat->kategori_id }}"
                            {{ request('kategori') == $kat->kategori_id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-buttons">
                <button type="submit" class="btn-terapkan">Terapkan</button>
            </div>

            <div class="filter-buttons">
                <a href="{{ route('produk.index') }}" class="btn-reset">Reset</a>
            </div>

        </div>

    </form>
</div>

<div class="produk-grid-container">
    @if($produks->count() > 0)
        @foreach($produkPerKategori as $kategoriId => $produksInKategori)
            <div class="kategori-section">
                <h4 class="kategori-title">
                    {{ $produksInKategori->first()->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                </h4>

                <div class="row g-4">
                    @foreach ($produksInKategori as $p)
                        <div class="col-md-4">
                            <div class="produk-card">

                                <div class="produk-card-image">
                                    @if ($p->gambar)
                                        <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_produk }}">
                                    @else
                                        <div style="padding: 40px; color: #666;">Gambar</div>
                                    @endif
                                </div>

                                <div class="produk-card-body">
                                    <h5 class="produk-card-title">{{ $p->nama_produk }}</h5>
                                    <p class="produk-card-kategori">{{ $p->kategori->nama_kategori ?? '-' }}</p>
                                    
                                    <div class="produk-card-info">
                                        <p><strong>Harga:</strong> Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                        <p><strong>Stok:</strong> {{ $p->stok }}</p>
                                    </div>

                                    <div class="produk-card-deskripsi">
                                        <strong>Deskripsi:</strong> {{ Str::limit($p->deskripsi ?? 'Tidak ada deskripsi', 80) }}
                                    </div>
                                </div>

                                <div class="produk-card-actions">
                                    <a href="{{ route('produk.show', $p->produk_id) }}" class="btn-detail">Detail</a>
                                    <a href="{{ route('produk.edit', $p->produk_id) }}" class="btn-edit">Edit</a>
                                    
                                    <form action="{{ route('produk.destroy', $p->produk_id) }}" method="POST" class="form-hapus d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-hapus btn-delete">Hapus</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center">
            <p style="color: #000; font-weight: 600; padding: 40px;">Tidak ada produk ditemukan.</p>
        </div>
    @endif
</div>

<div class="pagination-container">
    {{ $produks->links() }}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Apakah yakin ingin menghapus produk ini?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 2000
        });
    @endif

});
</script>
@endpush