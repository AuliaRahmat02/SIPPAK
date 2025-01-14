<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use App\Http\Controllers\Controller;


class PegawaiController extends Controller
{
    function show()
    {
        // memanggil data dari api

        $bookController = new BookController();
        $data = $bookController->index();

        return view('duk',['buku'=>$data,'title'=>'Daftar Urut Kepangkatan']);
    }


    public function profil($nip){
        $profil = pegawai::all();
        return $profil;
    }
}
