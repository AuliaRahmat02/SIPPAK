<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\KGB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

use function Laravel\Prompts\table;

class CutiExport extends BaseExport
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
            $judul = "REKAPITULASI NAMA-NAMA PEGAWAI NEGERI SIPIL YANG MENGAMBIL CUTI
            DI LINGKUNGAN SEKRETARIAT DAERAH PROVINSI SUMATERA BARAT
            PADA BULAN JANUARI, FEBRUARI, MARET, APRIL, MEI DAN JUNI";
        }else{
            $judul = "REKAPITULASI NAMA-NAMA PEGAWAI NEGERI SIPIL YANG MENGAMBIL CUTI
            DI LINGKUNGAN SEKRETARIAT DAERAH PROVINSI SUMATERA BARAT
            PADA BULAN JULI, AGUSTUS, SEPTEMBER, OKTOBER, NOVEMBER DAN DESEMBER";
        }
        $data = DB::table('pegawais');
        // $data->whereMonth('tmt_gaji', $bulanPilihan);

        //menentukan data yang akan dia ambil

                    // ->get();
                    $dataBaru =$data = DB::table('pegawais')
                    ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
                    ->select('pegawais.*',
                    'cuti_ver_models.fase as fase',
                    'cuti_ver_models.hari as hari',
                    'cuti_ver_models.mulai as mulai',
                    'cuti_ver_models.selesai as selesai',
                    'cuti_ver_models.jenis as jenis',
                    'cuti_ver_models.verif as verif')
                    ->where('fase','>=',2)
                    ->get();


        $collection = $dataBaru->map(function($items) {


        $arr[] = [
            1 => "Cuti Tahunan",
            2 => "Cuti Sakit",
            3 => "Cuti Melahirkan",
            4 => "Cuti Alasan Penting",
            5 => "Cuti di Luar Tanggungan Negara",
            6 => "Cuti Besar",

        ];


            return [
                'Nama/Nip' => $items->nama_pns . "\r\n" . $items->nip,
                'Unit Kerja' =>$items->opd_nm,
                'Jenis Cuti' =>$items->jenis,
                'Mulai'=>$items->mulai,
                'Selesai'=>$items->selesai,
                'Hari'=>$items->hari,
                'Keterangan'
            ];
        });

        $headings = [
            'Nama/Nip',
            'Unit Kerja',
            'Jenis Cuti',
            'Mulai',
            'Selesai',
            'Hari',
            'Keterangan'
        ];



        parent::__construct($collection, $headings,$judul);
    }
}
