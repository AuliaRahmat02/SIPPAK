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
        Schema::create('kgb_ver_models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip',18);
            $table->foreign('nip')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->tinyInteger('fase')->default(0);
            $table->boolean('verif')->default(false);
            $table->string('gajiBaru',18);
            $table->string('gajiLama',18);
            $table->tinyText('suratSK');
            $table->string('noSK',50);
            $table->string('noSurat',50);
            $table->tinyText('pesan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kgb_ver_models');
    }
};
