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
        Schema::create('pesanan', function (Blueprint $table) {
    $table->id('id_pesanan');
    $table->foreignId('id_user')
          ->constrained('users', 'id_user')
          ->onDelete('cascade');
    $table->dateTime('tanggal')->useCurrent();
    $table->decimal('total_harga', 10, 2);
    $table->enum('status', ['menunggu','diproses','siap_diambil','selesai']);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
