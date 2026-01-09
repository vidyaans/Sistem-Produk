@extends('layouts.app')

@section('title', 'Edit Akun Admin | AISTOPHILE MANAGEMENT')

@section('content')
<link rel="stylesheet" href="{{ asset('css/superadmin.css') }}">

<div class="edit-admin-container">

    <div class="edit-admin-card">

        <div class="edit-admin-header">
            <h3>Edit Admin</h3>
            <span class="current-status {{ $admin->is_active ? 'status-aktif' : 'status-nonaktif' }}">
                {{ $admin->is_active ? 'Aktif' : 'Tidak Aktif' }}
            </span>
        </div>

        <form action="{{ route('superadmin.admin.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Username: {{ $admin->username }}</label>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select" required>
                    <option value="1" {{ $admin->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$admin->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="edit-admin-actions">
                <a href="{{ route('superadmin.dashboard') }}" class="btn-kembali">Kembali</a>
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            </div>
            
        </form>
        
    </div>
    
</div>

@endsection