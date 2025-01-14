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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('ID_User')->primary();
            $table->string('NIP_User',18)->unique();
            $table->string('Nama_User',18);
            $table->string('Password');
            $table->string('email',30)->unique();
            $table->integer('biro');
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('opadpim')->default(false);
            $table->boolean('jft')->default(false);
            $table->boolean('kabag')->default(false);
            $table->boolean('kabiro')->default(false);
            $table->string('tipedata',20)->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE users ADD ttd MEDIUMBLOB NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
