<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pesanan', function (Blueprint $table) {
        $table->text('catatan')->nullable();
        $table->string('metode_penerimaan')->after('catatan');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('pesanan', function (Blueprint $table) {
        $table->dropColumn(['catatan', 'metode_penerimaan']);
    });
}
};
