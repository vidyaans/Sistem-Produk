@extends('layouts.app')

@section('title', 'Detail Kategori Admin | AISTOPHILE MANAGEMENT')

@section('content')
<link rel="stylesheet" href="{{ asset('css/superadmin.css') }}">

<div class="produk-header-card">
    <h2>{{ $admin->username }}</h2>
    <span class="status-{{ $admin->is_active ? 'aktif' : 'nonaktif' }}">
        {{ $admin->is_active ? 'Aktif' : 'Tidak Aktif' }}
    </span>
</div>

<div class="kategori-list-card">
    
    <div class="kategori-list-header">
        <h3>Daftar Kategori</h3>
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
            <input type="text" id="searchInput" placeholder="Cari...">
        </div>
    </div>

    <table class="kategori-table" id="kategoriTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $index => $kategori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kategori->nama_kategori }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center">Tidak ada kategori</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-footer">
        <div class="pagination-info">
            Menampilkan <span id="showingCount">{{ count($kategoris) }}</span> dari {{ count($kategoris) }} data
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
    var table = $('#kategoriTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        searching: true,
        info: false,
        paginate: false,
        dom: 't',
        columnDefs: [
            { orderable: false, targets: 0 } 
        ]
    });
    
    $('#lengthSelect').on('change', function() {
        table.page.len($(this).val()).draw();
        updateInfo();
    });
    
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
        updateInfo();
        updateNumbers();
    });
    
    function updateInfo() {
        var info = table.page.info();
        $('#showingCount').text(info.recordsDisplay);
    }

    function updateNumbers() {
        table.rows({search: 'applied'}).every(function(rowIdx, tableLoop, rowLoop) {
            this.cell(rowIdx, 0).data(rowLoop + 1);
        });
    }
});
</script>

@endsection