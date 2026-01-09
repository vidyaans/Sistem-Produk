@extends('layouts.app')

@section('title', 'Dashboard Admin | AISTOPHILE MANAGEMENT')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="container">

  <div class="welcome-section">
    <div class="row align-items-center">
      <div class="col-md-6 welcome-text">
        <h2>Welcome!</h2>
        <p>Ini adalah pusat kendali Anda untuk mengatur seluruh inventaris dan operasional toko secara menyeluruh.</p>
      </div>

      <div class="col-md-6 total-boxes">
        <div class="total-box">
          <div class="total-title">Total Barang</div>
          <div class="total-number">{{ $totalProduk }}</div>
        </div>

        <div class="total-box">
          <div class="total-title">Total Kategori</div>
          <div class="total-number">{{ $totalKategori }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="dt-inner-card">
    <h3>BARANG HAMPIR HABIS</h3>
    <small>Stok ≤ 5</small>

    <table id="tabel-hampir-habis" class="table table-bordered">
      <thead>
        <tr>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Stok</th>
        </tr>
      </thead>
      <tbody>
        @foreach($hampirHabis as $p)
        <tr>
          <td>{{ $p->nama_produk ?? $p->nama }}</td>
          <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
          <td class="{{ $p->stok <= 2 ? 'text-lowstock' : '' }}">
            {{ $p->stok }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    $('#tabel-hampir-habis').DataTable({
        language: {
            search: "Cari:",
            info: "Menampilkan _END_ dari _TOTAL_ data",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    });
});
</script>
@endpush
