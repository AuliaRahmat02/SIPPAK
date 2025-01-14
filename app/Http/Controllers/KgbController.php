<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\history;
use App\Exports\KGBExport;
use App\Models\KgbVerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
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

    public function history($ket){
        history::Create([
            'NIP' => auth()->user()->NIP_User,
            'Nama'=> auth()->user()->Nama_User,
            'Keterangan'=>$ket]
        );
    }

    public function data($month, $year)
    {

        $this->history("Mencetak Surat KGB");
        $data = DB::table('pegawais')
            ->leftJoin("kgb_ver_models", 'pegawais.nip', '=', 'kgb_ver_models.nip')
            ->select('pegawais.*', 'kgb_ver_models.fase as fase', 'kgb_ver_models.verif as verif')
            // ->whereMonth('tmt_gaji_N',$month)
            // ->whereYear('tmt_gaji_N',$year)
            ->whereRaw('(MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)', [$month, $year, $month, $year])
            ->orderBy('golru_id', 'desc')
            ->orderBy('jabatan_id')
            ->get();
        return $data;
    }

    //
    public function show(Request $request)
    {
        // memanggil data dari api


        $data = DB::table('pegawais')
            ->leftJoin("kgb_ver_models", 'pegawais.nip', '=', 'kgb_ver_models.nip')
            // ->select('pegawais.*','kgb_ver_models.fase as fase','kgb_ver_models.verif as verif','kgb_ver_models.gajiLama as gajiLama','kgb_ver_models.gajiBaru as gajiBaru');
            ->select(
                'pegawais.*',
                'kgb_ver_models.gajiBaru as gajiBaru',
                // 'kgb_ver_models.noSK as noSK',
                'kgb_ver_models.noSurat as noSurat',
                'kgb_ver_models.fase as fase',
                'kgb_ver_models.verif as verif',
                'kgb_ver_models.pesan as pesan',
                'kgb_ver_models.gajiLama as gajiLama'
            );
        // $data = DB::table('pegawais');
        $bulan = $this->months[$request->months];
        // $bulan = "senin";
        // Apply month filter

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year; //tahun perbaikan


        if ($request->has('month')) {
            $allowedMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]; // February, May, September
            $indeksMonth = request()->month;
            if ($request->month == null) {
                // $data->whereRaw('(MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)',[$bulanIni, $tahunIni, $bulanIni, $tahunIni]);
                $data->whereMonth('tmt_gaji_N', $bulanIni);
                $data->whereYear('tmt_gaji_N', $tahunIni);
                $indeksMonth = Carbon::now()->month;
            } else {
                if($request->has('year')){
                    $data->whereMonth('tmt_gaji_N', $request->month);
                    $data->whereYear('tmt_gaji_N', $request->year);
                    $bulan = $this->months[$request->month];
                }else{

                    // $data->whereRaw('(MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)',[$request->month, $tahunIni, $request->month, $tahunIni]);
                    $data->whereMonth('tmt_gaji_N', $request->month);
                    $data->whereYear('tmt_gaji_N', $tahunIni);
                    $bulan = $this->months[$request->month];
                }
                // $this->month = $request->month;
            }
        } else {
            // $data->whereRaw('(MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)',[$bulanIni, $tahunIni, $bulanIni, $tahunIni]);
            $data->whereMonth('tmt_gaji_N', $bulanIni);
            $data->whereYear('tmt_gaji_N', $tahunIni);
            $bulan = $this->months[Carbon::now()->month];
            $indeksMonth = Carbon::now()->month;
        }
        // if($request->has('year')){
        //     $tahunIni = $request->year;
        // }


        $items = $data

            // ->whereRaw("(YEAR(tmt_gaji_N) = ?)",[$tahunIni])
            // ->whereRaw("(MONTH(tmt_gaji_N) = ?)",[$bulanIni])
            // ->orderByRaw('MONTH(tmt_gaji_N)')
            ->orderBy('golru_id', 'desc')
            ->orderBy('jabatan_id')
            ->get();
        // ->paginate(10);

        if (Gate::allows('kabiro') || Gate::allows('kabag') || Gate::allows('jft')) {
            $data = DB::table('pegawais')
                ->leftJoin("kgb_ver_models", 'pegawais.nip', '=', 'kgb_ver_models.nip')
                ->select(
                    'pegawais.nama_pns as nama_pns',
                    'kgb_ver_models.fase as fase',
                    'kgb_ver_models.nip as nip'
                )
                ->get();

            return view('kgb', ['buku' => $data, 'title' => 'Kenaikan Gaji Berkala']);
        }



        return view('kgb', ['buku' => $items, 'title' => 'Kenaikan Gaji Berkala', 'bulan' => $bulan, 'months' => $this->months, 'indeksMonth' => $indeksMonth]);
    }



    public function showDash1(Request $request)
    {

        $bulanIni = Carbon::now()->month;
        $request->merge(['month' => $bulanIni]);

        return $this->show($request);
    }



    public function showDash2(Request $request)
    {

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        if ($bulanIni == 12) {
            $bulanIni = 1;
            $tahunIni += 1;

        } else {
            $bulanIni += 1;
        }

        $request->merge(['month' => $bulanIni,'year' =>$tahunIni]);

        return $this->show($request);
        // return view('kgb',['buku'=>$items,'title'=>'Kenaikan Gaji Berkala','bulan'=>$this->months[$bulanIni],'months'=>$this->months,'indeksMonth'=>$indeksMonth]);

    }

    public function showDash3(Request $request)
    {

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year+1;
        if ($bulanIni == 12) {
            $bulanIni = 2;
            // $tahunIni += 1;

        } else if ($bulanIni == 11) {
            $bulanIni = 1;
        } else {
            $bulanIni += 2;
            $tahunIni -=1;
        }

        $request->merge(['month' => $bulanIni,'year' =>$tahunIni]);

        return $this->show($request);
        // return view('kgb',['buku'=>$items,'title'=>'Kenaikan Gaji Berkala','bulan'=>$this->months[$bulanIni],'months'=>$this->months,'indeksMonth'=>$indeksMonth]);

    }


    public function export_kgb()
    {
        $this->history("Mengexport File Kgb");
        // $bulan = 2;

        // return Excel::download(new KGBExport($bulan),"kgb.xlsx");
        return Excel::download(new KGBExport, "kgb.xlsx");
    }



    public static function naikGaji()
    {
        $tahunIni = Carbon::now()->year;
        $bulanIni = Carbon::now()->month;
        $data = DB::table('pegawais');
        $datab = DB::table('pegawais');
        $datac = DB::table('pegawais');

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

        if ($bulanIni == 12) {
            $bulanBesok = 1;
            $bulanLusa = 2;
            $tahunBesok = $tahunIni + 1;
            $tahunLusa = $tahunBesok;
        } else {
            $bulanBesok = $bulanIni + 1;
            $tahunBesok = $tahunIni;
            if ($bulanIni == 11) {
                $bulanLusa = 1;
                $tahunLusa = $tahunIni + 1;
            } else {
                $bulanLusa = $bulanBesok + 1;
                $tahunLusa = $tahunIni;
            }
        }
        // $data = $data
        // ->whereRaw("((MONTH(tmt_gaji_N) = ?)",[$bulanIni]);

        // $datab = $datab
        // ->whereRaw("((MONTH(tmt_gaji_N) = ?)",[$bulanBesok]);


        $items = $data
            ->whereRaw("(MONTH(tmt_gaji_N) = ?)", [$bulanIni])
            ->whereRaw("(YEAR(tmt_gaji_N) = ?)", [$tahunIni])
            // ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60)) AND
            // (MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)",[$bulanIni,$tahunIni,$bulanIni,$tahunIni])
            // ->whereRaw("nip NOT IN (SELECT DISTINCT nip FROM kgb_ver_models)")
            // ->orderBy('golru_id', 'desc')
            // ->orderBy('jabatan_id')
            ->count();


        $itemsNext = $datab
            ->whereRaw("(MONTH(tmt_gaji_N) = ?)", [$bulanBesok])
            ->whereRaw("(YEAR(tmt_gaji_N) = ?)", [$tahunBesok])
            // ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60)) AND
            //  (MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)",[$bulanBesok,$tahunBesok,$bulanBesok,$tahunBesok])

            // ->whereRaw("nip NOT IN (SELECT DISTINCT nip FROM kgb_ver_models)")
            // ->orderBy('golru_id', 'desc')
            // ->orderBy('jabatan_id')
            ->count();

        $itemsLusa = $datac
            ->whereRaw("(MONTH(tmt_gaji_N) = ?)", [$bulanLusa])
            ->whereRaw("(YEAR(tmt_gaji_N) = ?)", [$tahunLusa])
            ->count();


        $notifIni = KgbController::hitung($bulanIni);
        $notifBesok = KgbController::hitung($bulanBesok);
        $notifLusa = KgbController::hitung($bulanLusa);




        $hasilkgb = [$items, $bulan, $itemsNext, $months[$bulanBesok], $itemsLusa, $months[$bulanLusa], $notifIni, $notifBesok, $notifLusa];

        return $hasilkgb;
    }


    public static function hitung($month)
    {
        $itemsVerif = DB::table('pegawais')
            ->crossJoin("kgb_ver_models", 'pegawais.nip', '=', 'kgb_ver_models.nip')
            ->select(
                'pegawais.*',
                'kgb_ver_models.verif as verif',
            )
            ->whereMonth('tmt_gaji_N', $month)
            ->where('verif', 1)
            ->count();

        $itemsAjukan = DB::table('pegawais')
            ->crossJoin("kgb_ver_models", 'pegawais.nip', '=', 'kgb_ver_models.nip')
            ->select(
                'pegawais.*',
                'kgb_ver_models.verif as verif',
            )
            ->whereMonth('tmt_gaji_N', $month)
            ->where('verif', '!=', 1)
            ->count();

        $itemsPerbaikan = DB::table('pegawais')
            ->crossJoin("kgb_ver_models", 'pegawais.nip', '=', 'kgb_ver_models.nip')
            ->select(
                'pegawais.*',
                'kgb_ver_models.verif as verif',
            )
            ->whereMonth('tmt_gaji_N', $month)
            ->where('verif', -1)
            ->count();
        $ans = [$itemsVerif, $itemsAjukan - $itemsPerbaikan, $itemsPerbaikan];

        return $ans;
    }

    public function ajukanKGB($nip)
    {
        $this->history("Melakukan Pengajuan KGB");
        $isi = [
            'nip' => $nip,
            'fase' => 1,
        ];
        KgbVerModel::create($isi);

        return back();
    }


    public function verifKGB($nip)
    {
        $this->history("Melakukan Verifikasi KGB");
        if (Gate::allows('kabiro')) {
            DB::table('kgb_ver_models')
                ->where('nip', $nip)
                ->update(['fase' => 0, 'verif' => 1]);
        }
        if (Gate::allows('kabag')) {
            DB::table('kgb_ver_models')
                ->where('nip', $nip)
                ->update(['fase' => 3, 'verif' => 0]);
        }
        if (Gate::allows('jft')) {
            DB::table('kgb_ver_models')
                ->where('nip', $nip)
                ->update(['fase' => 2, 'verif' => 0]);
        }
        return redirect()->route('kgb.view');
    }

    public function KGB_JFT()
    {
        $data = DB::table('kgb_ver_models')
            ->get();

        return view('kgb', ['buku' => $data, 'title' => 'Kenaikan Gaji Berkala']);
    }

    public function verifKabiro($nip)
    {
        $this->history("Melakukan Verifikasi KGB");
        DB::table('kgb_ver_models')
            ->where('nip', $nip)
            ->update(['fase' => 0, 'verif' => 1]);

        return view();
    }
    public function removeKGB($nip, Request $request)
    {
        $this->history("Menolak Pengajuan KGB");
        DB::table('kgb_ver_models')
            ->where('nip', $nip)
            ->update(
                [
                    'pesan' => $request->pesan,
                    'verif' => '-1',
                    'fase' => '0'
                ]
            );

        return redirect()->route('kgb.view');
    }

    public function formAjukan($nip)
    {
        $data = DB::table('pegawais');

        $item = $data
            ->where('nip', $nip)
            ->get();

        $dataAdmin = DB::table('pegawais')
            ->crossJoin("kgb_ver_models", 'pegawais.nip', '=', 'kgb_ver_models.nip')
            ->select(
                'pegawais.*',
                // 'kgb_ver_models.noSK as noSK',
                'kgb_ver_models.gajiBaru as gajiBaru',
                'kgb_ver_models.gajiLama as gajiLama',
                'kgb_ver_models.noSurat as noSurat',
                'kgb_ver_models.noSK as noSK',
                'kgb_ver_models.suratSK as suratSK',
                'kgb_ver_models.pesan as pesan'
            )
            ->where('pegawais.nip', $nip)
            ->get();


        return view('formkgb',  ['title' => 'Pengajuan KGB', 'items' => $item, 'dataAdmin' => $dataAdmin]);
    }

    public function uploadKGB(Request $request)
    {

        // dd($request->nip);
        $this->history("Melakukan Pengajuan KGB");

        $isi = [
            'nip' => $request->nip,
            'fase' => 1,
            'gajiBaru' => $request->gajiPokok_N,
            'gajiLama' => $request->gajiPokok_B,
            'noSurat' => $request->noSurat,
            'noSK' => $request->noSK,
            'suratSK' => $request->suratSK,
            'pesan' => '',
            'verif' => 0
        ];


        $existingRecord = KgbVerModel::where('nip', $request->nip)->first();

        if ($existingRecord) {
            $existingRecord->update($isi);
        } else {
            // If no record exists, create a new one
            KgbVerModel::create($isi);
        }

        // KgbVerModel::create($isi);

        $bulanIni = Carbon::now()->month;
        $request->merge(['month' => $bulanIni]);


        return redirect()->route('dashUmum');
    }
}
