<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use function Laravel\Prompts\table;

class RekapKGBExport extends BaseExport
{
        protected $bulanDesc = [
            0 => 'Semua Bulan',
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
        ]; // Variable to hold the filter parameter

    // Constructor to accept parameter
    // public function __construct($bulanPilihan)
    public function __construct()
    {
        $tanggal = Carbon::now()->month;
        if($tanggal >= 7){
            $judul = "DAFTAR NAMA-NAMA PEGAWAI NEGERI SIPIL YANG DI TERBITKAN SURAT PEMBERITAHUAN
            KENAIKAN GAJI BERKALA DI LINGKUNGAN SEKRETARIAT DAERAH PROVINSI SUMATERA BARAT
            PADA BULAN JANUARI, FEBRUARI, MARET, APRIL, MEI DAN JUNI";
        }else{
            $judul = "DAFTAR NAMA-NAMA PEGAWAI NEGERI SIPIL YANG DI TERBITKAN SURAT PEMBERITAHUAN
            KENAIKAN GAJI BERKALA DI LINGKUNGAN SEKRETARIAT DAERAH PROVINSI SUMATERA BARAT
            PADA BULAN JULI, AGUSTUS, SEPTEMBER, OKTOBER, NOVEMBER DAN DESEMBER";
        }

        $dataBaru = DB::table('pegawais')
        ->crossJoin("kgb_ver_models",'pegawais.nip','=','kgb_ver_models.nip')
        ->select('pegawais.*',
        'kgb_ver_models.verif as verif',)
        ->where('verif',1)
        ->get();


        $collection = $dataBaru->map(function($items) {


            $i=1;
            return [
                ' '=>"   ",
                'Nama/Nip' => $items->nama_pns . "\r\n" . $items->nip,
                'Pangkat/Gol' => $items->pangkat. "\r\n". $items->golru_nm,
                'Tmt Berkala Terakhir' => $items->tmt_gaji,
                'Masa Kerja' => $items->masa_kerja,
                'Berkala Yang Akan Datang' => $items->tmt_gaji,
            ];
        });

        $headings = [
            'No',
            'Nama/Nip',
            'Golongan',
            'Tmt Gaji',
            'Unit Kerja',
            'Keterangan'
        ];



        parent::__construct($collection, $headings,$judul);
    }
}
