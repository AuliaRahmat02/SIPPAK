<?php

namespace App\Http\Controllers;

use App\Exports\DUKExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class DukController extends Controller
{
    public function index()
    {
        $data = DB::table('pegawais')
            ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60))")
            ->whereRaw('cpns_pns_id = 2 OR cpns_pns_id = 3')
            ->orderBy('golru_id', 'desc')
            ->orderBy('jabatan_id')
            ->get();


        return view('duk', ['buku' => $data, 'title' => 'DUK']);
    }

    public function ex_duk()
    {
        return Excel::download(new DUKExport, "DUK.xlsx");
    }
}
