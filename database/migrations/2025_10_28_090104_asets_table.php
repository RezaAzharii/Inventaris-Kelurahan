<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id('id_aset');
            $table->string('jenis_barang');
            $table->string('kode_barang');
            $table->string('identitas_barang');
            $table->string('pengelola_barang');
            $table->date('tahun_perolehan')->nullable();
            $table->decimal('nilai_perolehan', 15, 2)->nullable();
            $table->decimal('nilai_saat_ini', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
