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
        Schema::create('ijazah_gelars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip',18);
            $table->foreign('nip')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->string("surat")->nullable();
            $table->foreign('surat')->references("ID")->on("naik_ver2s")->onDelete('cascade');
            $table->tinyInteger('fase')->default(0);
            $table->text('tolak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ijazah_gelars');
    }
};
