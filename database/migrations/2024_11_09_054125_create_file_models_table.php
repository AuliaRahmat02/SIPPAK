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
        Schema::create('file_models', function (Blueprint $table) {
            $table->uuid("ID")->primary();
            $table->string("nip_pegawai",18);
            $table->string("nama");
            $table->foreign('nip_pegawai')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->tinyInteger('jenisBahan');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE file_models ADD file MEDIUMBLOB NULL");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_models');
    }
};
