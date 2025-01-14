<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pegawai;
use App\Models\naikVer2;
use App\Models\NaikVerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;



class NaikPangkatController extends Controller
{
    // menampilkan halaman naik pangkat
    public function show(Request $req){

        if (Gate::allows('opAdpem')) {
            return $this->NaikPangkatSQL('BIRO ADMINISTRASI PEMBANGUNAN',$req);
        }

        if (Gate::allows('opHukum')) {
            return $this->NaikPangkatSQL('BIRO HUKUM',$req);
        }

        if (Gate::allows('opKesra')) {
            return $this->NaikPangkatSQL('BIRO KESEJAHTERAAN RAKYAT',$req);
        }


        if (Gate::allows('opOrganisasi')) {
            return $this->NaikPangkatSQL('BIRO ORGANISASI',$req);
        }


        if (Gate::allows('opPBJ')) {
            return $this->NaikPangkatSQL('BIRO PENGADAAN BARANG DAN JASA',$req);
        }

        if (Gate::allows('opPemerintahan')) {
            return $this->NaikPangkatSQL('BIRO PEMERINTAHAN DAN OTONOMI DAERAH',$req);
        }


        if (Gate::allows('opPerekonomian')) {
            return $this->NaikPangkatSQL('BIRO PEREKONOMIAN',$req);
        }


        if (Gate::allows('opUmum')) {
            return $this->NaikPangkatSQL('BIRO UMUM',$req);
        }



        if (Gate::allows('opAdpim')) {
            return $this->NaikPangkatSQL("BIRO ADMINISTRASI PIMPINAN",$req);
        }
    }

    // parameter $biro dihilangkan sementara karena proses pengembangan tahap pertama. karena TU biro belum di beri akses
    // sintaks where biro juga dijadikan komentar hingga pengembangan tahap kedua rampung
    public function NaikPangkatSQL($biro,$req){
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;


        $data = DB::table('pegawais');
        $setSurat = 0;

        // Apply month filter
        if ($req->has('month') && $req->month != '') {
            switch ($req->month) {
                case 1:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 1) ");
                    break;

                case 2:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 2) ");
                    break;

                case 3:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 3) ");
                    break;

                case 4:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 4) ");
                    break;

                case 5:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 5) ");
                    break;

                case 6:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 6) ");
                    break;

                case 7:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 7) ");
                    break;

                case 8:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 8) ");
                    break;

                case 9:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 9) ");
                    break;

                case 10:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 10) ");
                    break;

                case 11:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 11) ");
                    break;

                case 12:
                    $data->whereRaw("(MONTH(tmt_golru_N) = 12) ");
                    break;
            }
        } else if (($bulanIni > 4) && ($bulanIni < 11)) {
            $setSurat = 1;
            $data->whereRaw("((MONTH(tmt_golru_N) > 4) AND (MONTH(tmt_golru_N) < 11))");
        } else {
            $setSurat = 1;
            $data->whereRaw( "((MONTH(tmt_golru_N) < 5) OR (MONTH(tmt_golru_N) > 10))");
        }

        $months = [
            '' => '',
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $items = $data
                    ->whereRaw("nip NOT IN (SELECT DISTINCT nip FROM naik_ver_models)")
                    ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60)) AND (YEAR(tmt_golru_N) = ? OR YEAR(tmt_golru_N) = ?)",[$tahunIni,$tahunIni])
                    ->where('opd_nm','=',$biro)
                    ->orderBy('golru_id', 'desc')
                    ->orderBy('jabatan_id')
                    ->get();
        // dd($items);
        return view('naikpangkat',[
            'title'=>'Naik Pangkat',
            'buku'=>$items,
            'bulan'=>$months[$req->month],
            'months'=>$months,
            'setSurat'=>$setSurat
        ]);
    }





    // fungsi membuat notifikasi untuk bagian DASHBOARD yang akan dilihat oleh pelaksana operator
    // biro di komentar karena akkses untuk biro masi ditutup
    public static function naiknotif($biro) {
        $tahunIni = Carbon::now()->year;
        $bulanIni = Carbon::now()->month;
        $data = DB::table('pegawais');

        if (($bulanIni > 4) && ($bulanIni < 11)) {
            $data->whereRaw("((MONTH(tmt_golru_N) > 4) AND (MONTH(tmt_golru_N) < 11))");
            $bulan = 'Oktober';
        } else {
            $data->whereRaw("((MONTH(tmt_golru_N) < 5) OR (MONTH(tmt_golru_N) > 10))");
            $bulan = 'April';
        }

        $items = $data
                    ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60)) AND (YEAR(tmt_golru_N) = ? OR YEAR(tmt_golru_N) = ?)",[$tahunIni,$tahunIni])
                    ->whereRaw("nip NOT IN (SELECT DISTINCT nip FROM naik_ver_models)")
                    ->where('opd_nm','=',$biro)
                    ->orderBy('golru_id', 'desc')
                    ->orderBy('jabatan_id')
                    ->count();
        $hasil = [$items,$bulan];
        return $hasil;
    }


    // fungsi untuk mengirim notif ke bagian operator adpim
    public function biro(Request $rr){
        $nip = $rr->validate([
            'nip'=>"required"
        ]);


        foreach ($nip['nip'] as $n) {
            $nes = [
                "nip" => $n,
                "fase" => 1,
            ];

            $naikver = ['naik'=>true];

            NaikVerModel::create($nes);
            pegawai::where('nip','=',$n)->update($naikver);
        }
        return back();
    }

    public function Hapus_Pemohon($nip){
        $naikver = ['naik'=>false];

        NaikVerModel::where('nip','=',$nip)->delete();
        pegawai::where('nip','=',$nip)->update($naikver);
        return back();
    }




    // menentukan periode kenaikan pangkat
    public static function periode_naik(){
        $bulanIni = Carbon::now()->month;
        if (($bulanIni > 4) && ($bulanIni<11)) {
            return 2;
        } else {
            return 2;
        }

    }

    // fungsi untuk mengirim notif ke bagian jft adpim
    public function P_naik_op(Request $req){
        $a = $req->validate([
            'nip'=>"required",
            'nama'=>"required",
            'nomor_surat'=>"required|max:10",
        ],[
            "nomor_surat"=>[
                "required"=>'Nomor Surat belum diisi !!',
                "max"=>'Nomor Surat terlalu panjang',
            ],
            "nama"=>[
                "required"=>'Nama Surat belum diisi !!'
            ],
        ]);

        // $pegawai = implode(",",$a['nip']);
        $periode = $this->periode_naik();
        // dd($a);
        $surat = [
            'nomor_surat'=> $a['nomor_surat'],
            'nama_surat'=> $a['nama'],
            'jenis_surat'=> 1, // 1 = kenaikan pangkat
            "periode" => $periode,
            "fase" => 1
        ];



        if (! Gate::any(["operator", "jft", "kabag", "kabiro"])) {
           $ambilID =  naikVer2::create($surat);

            foreach ($a['nip'] as $key ) {
                NaikVerModel::where('nip','=',$key)->update([
                    'fase'=>1,
                    'surat'=>$ambilID->ID
                ]);
            }
        }

        if (Gate::allows('operator')) {
           $ambilID =  naikVer2::create($surat);

            foreach ($a['nip'] as $key ) {
                NaikVerModel::where('nip','=',$key)->update([
                    'fase'=>2,
                    'surat'=>$ambilID->ID
                ]);
            }
        }

        if (Gate::allows('jft') ) {
            naikVer2::where('periode','=',$periode)->update($surat);

            foreach ($a['nip'] as $key ) {
                NaikVerModel::where('nip','=',$key)->update([
                    'fase'=>3,
                    'surat'=>$a["nomor_surat"]
                ]);
            }
        }

        if (Gate::allows('kabag')) {
            naikVer2::where('periode','=',$periode)->update($surat);

            foreach ($a['nip'] as $key ) {
                NaikVerModel::where('nip','=',$key)->update([
                    'fase'=>4,
                    'surat'=>$a["nomor_surat"]
                ]);
            }
        }

        if (Gate::allows('kabiro')) {
            naikVer2::where('periode','=',$periode)->update($surat);

            foreach ($a['nip'] as $key ) {
                NaikVerModel::where('nip','=',$key)->update([
                    'fase'=>5,
                    'surat'=>$a["nomor_surat"]
                ]);
            }
        }

        return back();
    }

    // Notifikasi surat kenaikan pangkat di tingkat jft kabag dan kabiro
    public static function kenaikanpangkatnotif($fase) {
        $hasil = NaikVerModel::LeftJoin("pegawais","naik_ver_models.nip",'=','pegawais.nip')
                                ->where('fase','=',$fase)
                                ->count();
        return $hasil;
    }

}
