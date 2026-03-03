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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique(); // INV-2024001
            $table->foreignId('user_id')->constrained('users'); // Pemesan
            $table->string('title'); // Judul Tagihan (ex: Sewa Genset 40kVA 2 Hari)
            $table->decimal('amount', 15, 2); // Jumlah Bayar
            $table->string('status')->default('pending');
            $table->string('payment_proof')->nullable(); // Bukti Bayar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
