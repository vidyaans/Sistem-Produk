<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            // Primary key produk
            $table->id('produk_id');

            // Relasi ke admin pemilik produk
            $table->foreignId('admin_id')
                ->constrained('admins')
                ->cascadeOnDelete();

            // Relasi ke kategori produk
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')
                ->references('kategori_id')
                ->on('kategoris')
                ->cascadeOnDelete();

            // Data utama produk
            $table->string('nama_produk', 100);
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);

            // Deskripsi dan gambar produk
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();

            // Timestamp created_at & updated_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Menghapus tabel produks
        Schema::dropIfExists('produks');
    }
};
