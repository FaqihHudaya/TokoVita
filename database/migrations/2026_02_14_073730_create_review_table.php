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
        Schema::create('review', function (Blueprint $table) {
    $table->id('id_review');
    $table->foreignId('id_user')
          ->constrained('users', 'id_user')
          ->onDelete('cascade');
    $table->foreignId('id_produk')
          ->constrained('produk', 'id_produk')
          ->onDelete('cascade');
    $table->integer('rating');
    $table->text('komentar')->nullable();
    $table->dateTime('tanggal')->useCurrent();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};
