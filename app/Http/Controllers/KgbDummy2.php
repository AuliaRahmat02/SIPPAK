<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Exports\KGBExport;
use App\Models\KgbVerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class KgbController extends Controller
{

    private $months = [
        "" => 'Semua Bulan',
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
        12 => 'Desember'
    ];

    public function data($month,$year){
        $data = DB::table('pegawais')
            ->leftJoin("kgb_ver_models",'pegawais.nip','=','kgb_ver_models.nip')
            ->select('pegawais.*','kgb_ver_models.fase as fase','kgb_ver_models.verif as verif')
            ->whereMonth('tmt_gaji_N',$month)
            ->whereYear('tmt_gaji_N',$year)
            ->orderBy('golru_id','desc')
            ->orderBy('jabatan_id')
            ->get();
        return $data;
        }

    //
    public function show(Request $request){
        // memanggil data dari api

        $data = DB::table('pegawais')
        ->leftJoin("kgb_ver_models",'pegawais.nip','=','kgb_ver_models.nip')
        ->select('pegawais.*','kgb_ver_models.fase as fase','kgb_ver_models.verif as verif');
        // $data = DB::table('pegawais');
        $bulan = $this->months[$request->months];
        // Apply month filter

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;


        if ($request->has('month')) {
            $allowedMonths = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]; // February, May, September
            $indeksMonth = request()->month;

            if($request->month == null){
                $data->whereMonth('tmt_gaji_N', $bulanIni);
                $indeksMonth = Carbon::now()->month;
            }else if (in_array($request->month, $allowedMonths)) {
                $data->whereMonth('tmt_gaji_N', $request->month);
                $bulan = $this->months[$request->month].'red';
                // $this->month = $request->month;
            }
        }else{
            $data->whereMonth('tmt_gaji_N', $bulanIni);
            $bulan = $this->months[Carbon::now()->month].'red';
            $indeksMonth = Carbon::now()->month;
        }

        $items = $data
                            ->whereRaw("(YEAR(tmt_gaji_N) = ?)",[$tahunIni])
                            // ->orderByRaw('MONTH(tmt_gaji_N)')
                            ->orderBy('golru_id','desc')
                            ->orderBy('jabatan_id')
                            ->get();
                            // ->paginate(10);

        return view('kgb',['buku'=>$items,'title'=>'Kenaikan Gaji Berkala','bulan'=>$bulan,'months'=>$this->months,'indeksMonth'=>$indeksMonth]);

    }
    public function showDash1(Request $request){
        $indeksMonth = Carbon::now()->month;

        $data = DB::table('pegawais');

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $data->whereMonth('tmt_gaji_N',$bulanIni);

        $items = $data
        ->whereRaw("(YEAR(tmt_gaji_N) = ?)",[$tahunIni])
        ->orderBy('nip')
        ->orderBy('golru_id','desc')
        ->orderBy('jabatan_id')
        ->get();
        // ->paginate(10);

        $request->merge(['month' => $bulanIni]);
        return $this->show($request);
        // return view('kgb',['buku'=>$items,'title'=>'Kenaikan Gaji Berkala','bulan'=>$this->months[$bulanIni],'months'=>$this->months,'indeksMonth'=>$indeksMonth]);

    }
    public function showDash2(Request $request){
        $indeksMonth = Carbon::now()->month;
        $data = DB::table('pegawais');
        $tahunIni = Carbon::now()->year;
        $bulanIni = Carbon::now()->month;
        if($bulanIni == 12){
            $bulanIni = 1;
            $tahunIni += 1;
        }else{
            $bulanIni +=1;
        }
        $data->whereMonth('tmt_gaji',$bulanIni);


        $items = $data
                            ->whereRaw("(YEAR(tmt_gaji_N) = ?)",[$tahunIni])
                            ->orderBy('nip')
                            ->orderBy('golru_id','desc')
                            ->orderBy('jabatan_id')
                            ->get();
                            // ->paginate(10);

                            $request->merge(['month' => $bulanIni]);
                            return $this->show($request);
        // return view('kgb',['buku'=>$items,'title'=>'Kenaikan Gaji Berkala','bulan'=>$this->months[$bulanIni],'months'=>$this->months,'indeksMonth'=>$indeksMonth]);

    }


    public function export_kgb(){

        // $bulan = 2;

        // return Excel::download(new KGBExport($bulan),"kgb.xlsx");
        return Excel::download(new KGBExport,"kgb.xlsx");
    }

    public static function naikGaji(){
        $tahunIni = Carbon::now()->year;
        $bulanIni = Carbon::now()->month;
        $data = DB::table('pegawais');
        $datab = DB::table('pegawais');

        $months = [
            "" => 'Semua Bulan',
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
            12 => 'Desember'
        ];

        $bulan = $months[$bulanIni];

        if($bulanIni==12){
            $bulanBesok = 1;
            $tahunBesok = $tahunIni+1;
        }else{
            $bulanBesok = $bulanIni+1;
            $tahunBesok = $tahunIni;
        }
        // $data = $data
        // ->whereRaw("((MONTH(tmt_gaji_N) = ?)",[$bulanIni]);

        // $datab = $datab
        // ->whereRaw("((MONTH(tmt_gaji_N) = ?)",[$bulanBesok]);


        $items = $data
                    ->whereRaw("(MONTH(tmt_gaji_N) = ?)",[$bulanIni])
                    ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60)) AND (YEAR(tmt_gaji) = ? OR YEAR(tmt_gaji_N) = ?)",[$tahunIni,$tahunIni])
                    ->whereRaw("nip NOT IN (SELECT DISTINCT nip FROM kgb_ver_models)")
                    // ->orderBy('golru_id', 'desc')
                    // ->orderBy('jabatan_id')
                    ->count();


        $itemsNext = $datab
                    ->WhereRaw("(MONTH(tmt_gaji_N) = ?)",[$bulanBesok])
                    ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60)) AND (YEAR(tmt_gaji) = ? OR YEAR(tmt_gaji_N) = ?)",[$tahunBesok,$tahunBesok])
                    // ->whereRaw("nip NOT IN (SELECT DISTINCT nip FROM kgb_ver_models)")
                    // ->orderBy('golru_id', 'desc')
                    // ->orderBy('jabatan_id')
                    ->count();

        $hasilkgb = [$items,$bulan,$itemsNext,$months[$bulanBesok]];

        return $hasilkgb;
    }

    public function ajukanKGB($nip){

        $isi = [
            'nip' => $nip,
            'fase' => 1,
        ];
        KgbVerModel::create($isi);

        return back();
    }


    public function verifKGB($nip){
        DB::table('kgb_ver_models')
        ->where('nip',$nip)
        ->increment('fase');

        return back();
    }

    public function KGB_JFT(){
        $data = DB::table('kgb_ver_models')
                ->get();

                return view('kgb',['buku'=>$data,'title'=>'Kenaikan Gaji Berkala']);
    }

    public function verifKabiro($nip){
        DB::table('kgb_ver_models')
        ->where('nip',$nip)
        ->update(['fase'=>0,'verif'=>1]);

        return back();
    }
    public function removeKGB($nip){
        DB::table('kgb_ver_models')
        ->where('nip',$nip)
        ->delete();

        return back();
    }

}
