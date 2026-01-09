<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Username admin (unik)
            $table->string('username', 100)->unique();

            // Password admin (terenkripsi)
            $table->string('password');

            // Role admin (admin / superadmin)
            $table->enum('role', ['admin', 'superadmin'])->default('admin');

            // Timestamp created_at & updated_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Menghapus tabel admins
        Schema::dropIfExists('admins');
    }
};
