<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PensiunController;
use Maatwebsite\Excel\Concerns\FromCollection;

class NaikExport extends BaseExport
{


    // Constructor to accept parameter
    // public function __construct($bulanPilihan)
    public function __construct()
    {
        $periode = PensiunController::periode_naik();
        $tahunini = Carbon::now()->year;
        $data = DB::table('rekap_naik_pangkats')->leftjoin("pegawais","pegawais.nip","=","rekap_naik_pangkats.nip");
        // $data->whereMonth('tmt_gaji', $bulanPilihan);

        //menentukan data yang akan dia ambil

                    $dataBaru = $data

                    ->orderBy('golru_id','desc')
                    ->where('periode',"=",$periode)
                    ->whereRaw('YEAR(rekap_naik_pangkats.created_at) = ?',[$tahunini])
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

        $judul = "DAFTAR NAMA-NAMA PEGAWAI NEGERI SIPIL YANG DI TERBITKAN SURAT PEMBERITAHUAN
KENAIKAN GAJI BERKALA DI LINGKUNGAN SEKRETARIAT DAERAH PROVINSI SUMATERA BARAT
PADA BULAN FEBRUARI, APRIL, JUNI, AGUSTUS, OKTOBER, DESEMBER";

        parent::__construct($collection, $headings,$judul);
    }
}
