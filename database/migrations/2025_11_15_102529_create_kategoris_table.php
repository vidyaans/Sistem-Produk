<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            // Primary key kategori
            $table->id('kategori_id');

            // Relasi ke admin pemilik kategori
            $table->foreignId('admin_id')
                ->constrained('admins')
                ->cascadeOnDelete();

            // Nama kategori
            $table->string('nama_kategori', 100);

            // Deskripsi kategori (opsional)
            $table->text('deskripsi')->nullable();

            // Timestamp created_at & updated_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Menghapus tabel kategoris
        Schema::dropIfExists('kategoris');
    }
};
