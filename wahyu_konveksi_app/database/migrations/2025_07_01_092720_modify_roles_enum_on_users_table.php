<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Perluas sementara enum untuk menghindari error
        DB::statement("ALTER TABLE users MODIFY roles ENUM('admin', 'staff', 'user', 'kasir') NOT NULL DEFAULT 'kasir'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY roles ENUM('admin', 'staff', 'user') NOT NULL DEFAULT 'user'");
    }
};

