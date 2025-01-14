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
        Schema::create('rekap_pensiuns', function (Blueprint $table) {
            $table->uuid("ID");
            $table->string("nip",18);
            $table->foreign('nip')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->tinyInteger("periode");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_pensiuns');
    }
};
