<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Status aktif akun admin
            $table->boolean('is_active')->default(1)->after('role');

            // Waktu terakhir login admin
            $table->timestamp('last_login')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        // Menghapus kolom keamanan admin
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'last_login']);
        });
    }
};
