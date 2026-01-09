@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/daftar-kategori.css') }}">

<div class="kategori-header">
    <h3>Daftar Kategori</h3>
    <a href="{{ route('kategori.create') }}" class="btn-tambah-kategori">+ Tambah Kategori</a>
</div>

<div class="dt-kategori-card">

    <table id="kategoriTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $k)
            <tr>
                <td>{{ $k->nama_kategori }}</td>
                <td>{{ $k->deskripsi }}</td>
                <td class="aksi-column">
                    <a href="{{ route('kategori.edit', $k->kategori_id) }}" class="btn-edit-kategori" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('kategori.destroy', $k->kategori_id) }}" 
                        method="POST"
                        class="delete-form d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-hapus-kategori btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<div id="footer-kategori-pagination"></div>

@endsection

@push('scripts')
<script>
$(function() {
    if ($.fn.DataTable.isDataTable('#kategoriTable')) {
        $('#kategoriTable').DataTable().destroy();
    }

    var table = $('#kategoriTable').DataTable({
        pageLength: 10,
        lengthChange: true,
        ordering: true,
        searching: true,
        info: true,
        language: {
            search: "Cari:",
            lengthMenu: "Menampilkan _MENU_ Data",
            info: "Menampilkan _END_ dari _TOTAL_ data",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        },
        dom: 'lfrtip'
    });

    moveFooter();
    table.on('draw', moveFooter);
});

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function (e) {
            let form = this.closest('form'); 

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan hilang permanen!",
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
    });
});
</script>
@endpush
