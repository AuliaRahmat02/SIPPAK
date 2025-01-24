<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\KGB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

use function Laravel\Prompts\table;

class KGBExport extends BaseExport
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
        $data = DB::table('pegawais');
        // $data->whereMonth('tmt_gaji', $bulanPilihan);

        //menentukan data yang akan dia ambil

                    // ->get();
                    $dataBaru = $data
                    // sql penentuan pensiun
                    ->whereRaw('(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60))')
                    // ->whereRaw('opd_id = 1')
                    // ->whereMonth('tmt_golru', $month)
                    ->orderBy('golru_id','desc')
                    ->get();
                    // if($month!=0){
                    // }
                    // $data->get();


        $collection = $dataBaru->map(function($items) {


            return [
                'Nama/Nip' => $items->nama_pns . "\r\n" . $items->nip,
                'Pangkat/Gol' => $items->pangkat. "\r\n". $items->golru_nm,
                'Tmt Berkala Terakhir' => $items->tmt_gaji,
                'Masa Kerja' => $items->masa_kerja,
                'Berkala Yang Akan Datang' => $items->tmt_gaji,
            ];
        });

        $headings = [
            'Nama/Nip',
            'Pangkat/Gol',
            'Tmt Berkala Terakhir',
            'Masa Kerja',
            'Berkala Yang Akan Datang',
            'Keterangan'
        ];



        parent::__construct($collection, $headings,$judul);
    }
}
