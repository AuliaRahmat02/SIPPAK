<?php

namespace App\Http\Controllers;

use App\Exports\ExportPeople;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class BezController extends Controller
{
    public function showbz()
    {
        $data = DB::table('pegawais')
            ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60))")
            ->orderBy('golru_id', 'desc')
            ->orderBy('jabatan_id')
            ->get();


        return view('bezzetting', ['buku' => $data, 'title' => 'Bezzetting']);
    }

    public function ex_bz()
    {
        return Excel::download(new ExportPeople, "bezetting.xlsx");
    }
}
