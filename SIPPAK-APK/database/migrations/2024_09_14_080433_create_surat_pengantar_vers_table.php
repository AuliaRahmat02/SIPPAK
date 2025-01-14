<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_pengantar_vers', function (Blueprint $table) {
            $table->uuid('id_surat')->primary();
            $table->string('nama_surat');
            $table->string('nomor_surat');
            $table->tinyInteger("jenis");
            $table->timestamps();
        });
        DB::statement("ALTER TABLE surat_pengantar_vers ADD file MEDIUMBLOB NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantar_vers');
    }
};
