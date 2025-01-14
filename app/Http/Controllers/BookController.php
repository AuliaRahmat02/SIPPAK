<?php

namespace App\Http\Controllers;
// namespace App\Console\Commands;


use Carbon\Carbon;
use App\Models\pegawai;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function fetchAndStore()
    {
        try {
            // Contoh URL API
            $response = Http::get('https://simpeg.sumbarprov.go.id/webapi/setda/pegawai/list/token/f14a63de-4a66-11ef-b795-4c21c062aa2e');

            $items = $response->json();
            $items = $items['result'];
            // memasukkan data API ke database migration
            foreach ($items as $itemData) {
                pegawai::updateOrCreate(
                    ['nip' => $itemData['nip']],
                    [
                        "opd_id"=>$itemData["opd_id"],
                        "opd_nm"=>$itemData["opd_nm"],
                        "sub_opd_id"=>$itemData["sub_opd_id"],
                        "sub_opd_nm"=>$itemData["sub_opd_nm"],
                        "jns_jbtn_id"=>$itemData["jns_jbtn_id"],
                        "jns_jbtn_nm"=>$itemData["jns_jbtn_nm"],
                        "jabatan_id"=>$itemData["jabatan_id"],
                        "jabatan_nm"=>$itemData["jabatan_nm"],
                        "tmt_jabatan"=>$this->tanggal($itemData["tmt_jabatan"]),
                        "nama_pns"=>$itemData["nama_pns"],
                        "tmpt_lahir"=>$itemData["tmpt_lahir"],
                        "tgl_lahir"=>$this->tanggal($itemData["tgl_lahir"]),
                        "gender_id"=>$itemData["gender_id"],
                        "gender_nm"=>$itemData["gender_nm"],
                        "agama_id"=>$itemData["agama_id"],
                        "agama_nm"=>$itemData["agama_nm"],
                        "karpeg"=>$itemData["karpeg"],
                        "cpns_pns_id"=>$itemData["cpns_pns_id"],
                        "cpns_pns_nm"=>$itemData["cpns_pns_nm"],
                        "status_pns_id"=>$itemData["status_pns_id"],
                        "status_pns_nm"=>$itemData["status_pns_nm"],
                        "alamat"=>$itemData["alamat"],
                        "kawin_id"=>$itemData["kawin_id"],
                        "kawin_nm"=>$itemData["kawin_nm"],
                        "no_askes"=>$itemData["no_askes"],
                        "taspen"=>$itemData["taspen"],
                        "npwp"=>$itemData["npwp"],
                        "karis"=>$itemData["karis"],


                        "sk_cpns"=>$itemData["sk_cpns"],
                        "tgl_cpns"=>$this->tanggal($itemData["tgl_cpns"]),
                        "tmt_cpns"=>$this->tanggal($itemData["tmt_cpns"]),
                        "golru_cpns"=>$itemData["golru_cpns"],
                        
                        "sk_pns"=>$itemData["sk_pns"],
                        "tgl_pns"=>$this->tanggal($itemData["tgl_pns"]),
                        "tmt_pns"=>$this->tanggal($itemData["tmt_pns"]),
                        "golru_pns"=>$itemData["golru_pns"],
                        "golru_id"=>$itemData["golru_id"],
                        "golru_nm"=>$itemData["golru_nm"],
                        "pangkat"=>$itemData["pangkat"],
                        "tmt_golru_B"=>$this->tmtGolruB($itemData["tmt_golru"]),
                        "tmt_golru"=>$this->tanggal($itemData["tmt_golru"]),
                        "tmt_golru_N"=>$this->tmtGolruN($itemData["tmt_golru"]),
                        "masa_kerja"=>$itemData["masa_kerja"],


                        "tmt_gaji_B"=>$this->tmtGajiB($itemData["tmt_gaji"]),
                        "tmt_gaji"=>$this->tanggal($itemData["tmt_gaji"]),
                        "tmt_gaji_N"=>$this->tmtGajiN($itemData["tmt_gaji"]),
                        "mk_gaji"=>$itemData["mk_gaji"],
                        "gapok"=>$itemData["gapok"],


                        "eselon_id"=>$itemData["eselon_id"],
                        "eselon_nm"=>$itemData["eselon_nm"],
                        "jenjang_id"=>$itemData["jenjang_id"],
                        "jenjang_nm"=>$itemData["jenjang_nm"],
                        "kode_study"=>$itemData["kode_study"],
                        "jenjang_study"=>$itemData["jenjang_study"],
                        "nama_study"=>$itemData["nama_study"],
                        "jurusan"=>$itemData["jurusan"],
                        "usia"=>$this->usia($itemData['tgl_lahir']),

                    ]
                );
            }
            return back()->with(["T"=>"Data Berhasil"]);
        } catch (\Throwable $th) {
            
        }finally{
            return back()->with("F", "Data gagal di refresh");
        }

        
    }


    // fungsi untuk mengubah string menjadi tanggal
    public function tanggal($tanggal){
        if((($tanggal==="0000-00-00") || ($tanggal==="")) || ($tanggal===" " || $tanggal === "-")){
            return $a = null;
        }else{
            $a = Carbon::parse($tanggal);
            return $a;
        }
    }

    public function usia($a){
        return Carbon::parse($a)->age;
    }

    function tmtGolruN($tmt_now)
    {
        if($tmt_now=="0000-00-00"){
            return null;
        }else{
            $tahunIni = Carbon::now()->year; //tahun saat ini
            $tmt = Carbon::parse($tmt_now)->year;// tmt saat ini
            $tmtC = Carbon::parse($tmt_now)->year();// tmt saat ini

            $selisih = $tahunIni - $tmt; //menghitung selisih dari tahun
            $mod = $selisih % 4;// mencari modulus dari tahun

            if ($selisih == 0) {
                $tahun_NN = $tmtC->copy()->year($tahunIni+4);
                return $tahun_NN;
            }else if($mod == 0){
                $tahun_NN = $tmtC->copy()->year($tahunIni);
                return $tahun_NN;
            }else{
                $tahun_N = $tahunIni + 4 - $mod;
                $tahun_NN = $tmtC->copy()->year($tahun_N);
                return $tahun_NN;
            }            
        }
    }

    function tmtGolruB($tmt_now)
    {
        if(($tmt_now=="0000-00-00")){
            return null;
        }else{
            $interval = 4;//menentukan pengurangan untuk 4 tahun ke belakang
            $tmt = Carbon::parse($tmt_now);
            $tahun = $tmt->year;
            $B_tahun = $tahun - $interval;
            $tmt_B = $tmt->copy()->year($B_tahun);
    
            return $tmt_B->format('Y-m-d');
        }
    }
    function tmtGajiN($tmt_now)
    {
        if(($tmt_now=="0000-00-00")){
            return null;
        }else{
            $tahunIni = Carbon::now()->year; //tahun saat ini
            $tmt = Carbon::parse($tmt_now)->year;// tmt saat ini
            $tmtC = Carbon::parse($tmt_now)->year();// tmt saat ini

            $selisih = $tahunIni - $tmt; //menghitung selisih dari tahun
            $mod = $selisih % 2;// mencari modulus dari tahun

            if ($tmt_now == Carbon::now()) {
                $tahun_NN = $tmtC->copy()->year($tahunIni+2);
                return $tahun_NN;
            }else if ($selisih == 0) {
                $tahun_NN = $tmtC->copy()->year($tahunIni+2);
                return $tahun_NN;
            }else if($mod == 0){
                $tahun_NN = $tmtC->copy()->year($tahunIni);
                return $tahun_NN;
            }else{
                $tahun_N = $tahunIni + 2 - $mod;
                $tahun_NN = $tmtC->copy()->year($tahun_N);
                return $tahun_NN;
            }                      
        }
    }

    function tmtGajiB($tmt_now)
    {
        if(($tmt_now=="0000-00-00")){
            return null;
        }else{
            $interval = 2;
            $tmt = Carbon::parse($tmt_now);
            $tahun = $tmt->year;
            $B_tahun = $tahun - $interval;
            $tmt_B = $tmt->copy()->year($B_tahun);
    
            return $tmt_B->format('Y-m-d');
        }
    }


}
