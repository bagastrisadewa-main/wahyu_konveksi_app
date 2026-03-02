<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Finalisasi enum roles hanya 'admin' dan 'kasir'
        DB::statement("ALTER TABLE users MODIFY roles ENUM('admin', 'kasir') NOT NULL DEFAULT 'kasir'");
    }

    public function down(): void
    {
        // Kembalikan enum sebelumnya jika perlu
        DB::statement("ALTER TABLE users MODIFY roles ENUM('admin', 'staff', 'user', 'kasir') NOT NULL DEFAULT 'kasir'");
    }
};
