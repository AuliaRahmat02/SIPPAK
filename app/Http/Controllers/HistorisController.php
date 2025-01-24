<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class HistorisController extends Controller
{
    public function show()
    {
        $data=DB::table('histories')->get();


        return view('history', [ 'title' => 'History','dataHistory'=>$data]);
    }
}
