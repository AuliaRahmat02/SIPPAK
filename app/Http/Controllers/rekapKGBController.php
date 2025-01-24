<?php

namespace App\Http\Controllers;

use App\Exports\RekapKGBExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class RekapKGBController extends Controller
{
    public function show(){
        $data = DB::table('pegawais')
        ->crossJoin("kgb_ver_models",'pegawais.nip','=','kgb_ver_models.nip')
        ->select('pegawais.*',
        'kgb_ver_models.verif as verif',)
        ->where('verif',1)
        ->get();

        return view('rekapKGB',['buku'=>$data,'title'=>'Rekapitulasi KGB']);
    }
    public function export_kgb(){

        // $bulan = 2;

        // return Excel::download(new KGBExport($bulan),"kgb.xlsx");
        return Excel::download(new RekapKGBExport,"Rekapkgb.xlsx");
    }
}
