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
        Schema::create('cuti_ups', function (Blueprint $table) {
            $table->uuid('ID')->primary();
            $table->string('nip');
            $table->tinyInteger('jenis_file');
            $table->string('file_name');
            $table->string('file_type');
            $table->binary('file_data'); // Menggunakan binary untuk menyimpan file sebagai LONGBLOB
            $table->timestamps();
        });

        DB::statement('ALTER TABLE cuti_ups MODIFY file_data MEDIUMBLOB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti_ups');
    }
};
