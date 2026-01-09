@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/superadmin.css') }}">

<div class="welcome-section">
    <div class="welcome-card">
        <h3>Welcome Super Admin!</h3>
        <p>Otoritas penuh ada di tangan Anda untuk memastikan seluruh operasional platform dan manajemen pengguna berjalan tanpa hambatan.</p>
    </div>
    
    <div class="total-admin-card">
        <div class="label">Total Admin</div>
        <div class="number">{{ $totalAdmin }}</div>
    </div>
</div>

<div class="management-card">
    <div class="management-header">
        <h3>Manajemen Admin</h3>
    </div>

    <div class="dt-controls">
        <div>
            <label>Tampilkan</label>
            <select id="lengthSelect">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <span>Data</span>
        </div>
        
        <div>
            <label>Cari:</label>
            <input type="text" id="searchInput">
        </div>
    </div>

    <table class="admin-table" id="adminTable">
        <thead>
            <tr>
                <th>Username</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->username }}</td>
                <td>
                    <span class="status-{{ $admin->is_active ? 'aktif' : 'nonaktif' }}">
                        {{ $admin->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('superadmin.admin.show', $admin->id) }}" class="btn-icon btn-view">
                        <i class="fas fa-eye"></i>
                    </a>

                    <a href="{{ route('superadmin.admin.edit', $admin->id) }}" class="btn-icon btn-edit">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination-footer">
        <div class="pagination-info">
            Menampilkan <span id="showingCount">{{ count($admins) }}</span> dari {{ $totalAdmin }} data
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
    var table = $('#adminTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        searching: true,
        info: false,
        paginate: false,
        dom: 't'
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