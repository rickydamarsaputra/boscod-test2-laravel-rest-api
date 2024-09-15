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
        Schema::create('transaksi_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi');
            $table->bigInteger('nilai_transfer');
            $table->string('kode_unik');
            $table->bigInteger('biaya_admin');
            $table->bigInteger('total_transfer');
            $table->string('rekening_tujuan');
            $table->string('atasnama_tujuan');
            $table->string('rekening_perantara');
            $table->timestamp('berlaku_hingga');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bank_pengirim_id')->constrained()->on('banks')->cascadeOnDelete();
            $table->foreignId('bank_tujuan_id')->constrained()->on('banks')->cascadeOnDelete();
            $table->foreignId('bank_perantara_id')->constrained()->on('banks')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_transfers');
    }
};
