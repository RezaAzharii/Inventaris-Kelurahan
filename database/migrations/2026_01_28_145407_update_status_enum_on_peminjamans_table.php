<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE peminjamans 
            MODIFY status ENUM(
                'pending',
                'dipinjam',
                'ditolak',
                'dikembalikan'
            ) DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE peminjamans 
            MODIFY status ENUM(
                'dipinjam',
                'dikembalikan'
            )
        ");
    }
};