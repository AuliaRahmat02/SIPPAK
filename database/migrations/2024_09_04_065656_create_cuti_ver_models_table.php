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
        Schema::create('cuti_ver_models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip',18);
            $table->foreign('nip')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->tinyInteger('fase')->default(0);
            $table->boolean('verif')->default(false);
            $table->tinyInteger("jenis")->nullable();
            $table->string("nomor",20)->nullable();
            $table->string("hari")->nullable();
            $table->date("mulai")->nullable();
            $table->date("selesai")->nullable();
            $table->string("nomorSurat")->nullable();
            $table->tinyText("pesan")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti_ver_models');
    }
};
