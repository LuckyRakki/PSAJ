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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('nama_penyewa')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->integer('durasi_sewa')->nullable(); // Dalam hari
            $table->text('catatan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['nama_penyewa', 'no_hp', 'alamat_pengiriman', 'tanggal_mulai', 'durasi_sewa', 'catatan']);
        });
    }
};
