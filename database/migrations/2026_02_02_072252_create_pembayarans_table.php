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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->foreignId('transaksi_id')->constrained('transaksi', 'transaksi_id');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status_pembayaran');
            $table->date('tanggal_pembayaran');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
