<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

use function Laravel\Prompts\table;

class ExportPeople extends BaseExport
{
        protected $bulanDesc = [
            2 => 'Februari',
            4 => 'April',
            6 => 'Juni',
            8 => 'Agustus',
            10 => 'October',
            12 => 'December'
        ]; // Variable to hold the filter parameter

    // Constructor to accept parameter
    // public function __construct($bulanPilihan)
    public function __construct()
    {
        $data = DB::table('pegawais');
        // $data->whereMonth('tmt_gaji', $bulanPilihan);


        $dataBaru = $data
                    ->whereRaw('(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60))')
                    ->orderBy('golru_id', 'desc')
                    ->orderBy('masa_kerja','desc')
                    ->orderBy('usia','desc')
                    ->get();




        $collection = $dataBaru->map(function($items) {


            return [
                'Nama/Nip'=>$items->nama_pns."\n".$items->nip,
                'Gol'=>$items->pangkat."\n (".$items->golru_nm.')'."\n".'TMT :'.$items->tmt_golru,
                'Jabatan Sekarang'=>$items->jabatan_nm,
                'Unit Kerja'=>$items->sub_opd_nm,
                'Masa Kerja'=>$items->masa_kerja,
                'Struktural'=>'Belum ada data',//struktural belum ada data
                'Umum'=>$items->jenjang_study."\n".$items->jurusan,
                'Umur'=>$items->usia.' Thn',
                'Jenis Kelamin'=>$items->gender_nm,
                'Agama'=>$items->agama_nm,
            ];
        });

        $headings = [
            'Nama/Nip',
            'Gol',
            'Jabatan Sekarang',
            'Unit Kerja',
            'Masa Kerja',
            'Struktural',
            'Umum',
            'Umur',
            'Jenis Kelamin',
            'Agama',
        ];

        $judul = "DAFTAR BEZZETTING PNS SETDA PROV. SUMBAR KEADAAN DESEMBER 2024";

        parent::__construct($collection, $headings,$judul);
    }
}
