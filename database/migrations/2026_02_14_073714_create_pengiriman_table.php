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
       Schema::create('pengiriman', function (Blueprint $table) {
    $table->id('id_pengiriman');
    $table->foreignId('id_pesanan')
          ->constrained('pesanan', 'id_pesanan')
          ->onDelete('cascade');
    $table->string('metode_pengiriman', 50)->default('Ambil di Toko');
    $table->string('kode_pengambilan', 20)->nullable();
    $table->enum('status_pengambilan', ['menunggu','sudah_diambil'])->nullable();
    $table->dateTime('tanggal_pengambilan')->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
