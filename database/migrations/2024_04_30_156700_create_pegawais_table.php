<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {

            $table->integer("opd_id")->default(); 
            $table->string("opd_nm")->default(); 
            $table->integer("sub_opd_id")->default(); 
            $table->string("sub_opd_nm")->default(); 
            $table->integer("jns_jbtn_id")->default(); 
            $table->string("jns_jbtn_nm")->default(); 
            $table->integer("jabatan_id")->default(); 
            $table->string("jabatan_nm")->default(); 
            $table->date("tmt_jabatan")->nullable();


            $table->string("nip")->primary(); 
            $table->string("nama_pns"); 
            $table->string("tmpt_lahir")->default("-"); 
            $table->date("tgl_lahir"); 
            $table->integer("gender_id"); 
            $table->string("gender_nm"); 
            $table->integer("agama_id"); 
            $table->string("agama_nm"); 
            $table->string("karpeg")->default(); 
            $table->integer("cpns_pns_id")->default(); 
            $table->string("cpns_pns_nm")->default(); 
            $table->integer("status_pns_id")->default(); 
            $table->string("status_pns_nm")->default("-"); 
            $table->string("alamat")->default("-"); 
            $table->integer("kawin_id"); 
            $table->string("kawin_nm")->default("-"); 
            $table->string("no_askes")->default("-"); 
            $table->string("taspen")->default("-"); 
            $table->string("npwp")->default("-"); 
            $table->string("karis")->default("-");


            $table->string("sk_cpns")->default("-"); 
            $table->date("tgl_cpns")->nullable(); 
            $table->date("tmt_cpns")->nullable();
            $table->string("golru_cpns")->default();
            
            
            $table->string("sk_pns")->default("-");
            $table->date("tgl_pns")->nullable(); 
            $table->date("tmt_pns")->nullable();


            $table->string("golru_pns")->default();  
            $table->string("golru_id")->default(); 
            $table->string("golru_nm")->default(); 
            $table->string("pangkat")->default(); 
            $table->date("tmt_golru_B")->nullable();
            $table->date("tmt_golru")->nullable();
            $table->date("tmt_golru_N")->nullable();
            $table->string("masa_kerja")->default();
            
            
            $table->date("tmt_gaji_B")->nullable();  
            $table->date("tmt_gaji")->nullable(); 
            $table->date("tmt_gaji_N")->nullable(); 
            $table->string("mk_gaji")->default(); 
            $table->double("gapok")->nullable();


            $table->string("eselon_id")->default(); 
            $table->string("eselon_nm")->default(); 
            $table->string("jenjang_id")->default(); 
            $table->string("jenjang_nm")->default(); 
            $table->string("kode_study")->nullable(); 
            $table->string("jenjang_study")->nullable(); 
            $table->string("nama_study")->nullable(); 
            $table->string("jurusan")->nullable();
            $table->integer("usia");
            $table->tinyInteger("jatah_cuti")->default(12);
            $table->boolean('naik')->default(false);
            $table->boolean('cuti')->default(false);
            $table->boolean('pensiun')->default(false);
            $table->boolean('kartu')->default(false);
            $table->boolean('belajar')->default(false);
            $table->boolean('ijazah')->default(false);
            $table->boolean('satyalencana')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};

