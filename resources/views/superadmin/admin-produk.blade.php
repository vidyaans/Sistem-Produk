@extends('layouts.app')

@section('title', 'Detail Produk Admin | AISTOPHILE MANAGEMENT')

@section('content')
<link rel="stylesheet" href="{{ asset('css/superadmin.css') }}">

<div class="produk-header-card">
    <h2>{{ $admin->username }}</h2>
    <span class="status-{{ $admin->is_active ? 'aktif' : 'nonaktif' }}">
        {{ $admin->is_active ? 'Aktif' : 'Tidak Aktif' }}
    </span>
</div>

<div class="produk-list-card">
    
    <div class="produk-list-header">
        <h3>Daftar Produk</h3>
    </div>

    <div class="filter-section">
        <div class="filter-content">
            <label>Filter Berdasarkan Kategori</label>
            <form method="GET" id="filterForm">
                <div class="filter-controls">
                    <div>
                        <select name="kategori_id" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->kategori_id }}" {{ request('kategori_id') == $kat->kategori_id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ url()->current() }}" class="btn-reset-filter">
                        Reset Filter
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="dt-controls">
        <div>
            <label>Tampilkan</label>
            <select id="lengthSelect">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
            </select>
            <span>Data</span>
        </div>
        
        <div>
            <label>Cari:</label>
            <input type="text" id="searchInput">
        </div>
    </div>

    <table class="produk-table" id="produkTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $index => $produk)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                <td class="{{ $produk->stok <= 5 ? '' : '' }}">{{ $produk->stok }}</td>
                <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            @if(count($produks) == 0)
            <tr>
                <td colspan="5" class="text-center">Tidak ada produk</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="pagination-footer">
        <div class="pagination-info">
            Menampilkan <span id="showingCount">{{ count($produks) }}</span> dari {{ count($produks) }} data
        </div>
        <div class="pagination-buttons">
            <button class="btn-prev">Sebelumnya</button>
            <span class="page-number active">1</span>
            <button class="btn-next">Berikutnya</button>
        </div>
    </div>
    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#produkTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        searching: true,
        info: false,
        paginate: false,
        dom: 't',
        language: {
            emptyTable: "Tidak ada data produk"
        }
    });

    $('#lengthSelect').on('change', function() {
        table.page.len($(this).val()).draw();
        updateInfo();
    });

    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
        updateInfo();
    });

    function updateInfo() {
        var info = table.page.info();
        $('#showingCount').text(info.recordsDisplay);
    }
});
</script>

@endsection