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
        Schema::create('naik_ver2s', function (Blueprint $table) {
            $table->uuid('ID')->primary();
            $table->string('nomor_surat',10);
            $table->text('nama_surat');
            $table->tinyInteger('jenis_surat');
            $table->tinyInteger('periode')->nullable();
            $table->date('tanggal')->nullable();
            $table->tinyInteger('fase');
            $table->text('tolak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naik_ver2s');
    }
};
