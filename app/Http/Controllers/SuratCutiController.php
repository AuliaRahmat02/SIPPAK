<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
// use public\template;
// use Illuminate\Http\Request;
header('Content-Description: File Transfer');

header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');


class SuratCutiController extends Controller
{
    private $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
    public function history($ket){
        history::Create([
            'NIP' => auth()->user()->NIP_User,
            'Nama'=> auth()->user()->Nama_User,
            'Keterangan'=>$ket]
        );
    }
    public function cetak($nip){
        $this->history("Mencetak Surat Cuti");

        // $nip = 199606052018081003;
        // $data = DB::table('pegawais')
        // ->where('nip',$nip)
        // ->get();
        // // ->first();

        $student = DB::table('users')
        ->select('ttd')
        ->where('kabiro', 1)
        ->first();


        $data = DB::table('pegawais')
        ->leftJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
        ->where('pegawais.nip',$nip)
        ->select('pegawais.*',
        'cuti_ver_models.hari as hariCuti',
        'cuti_ver_models.mulai as mulai',
        'cuti_ver_models.selesai as selesai',
        'cuti_ver_models.jenis as jenisCuti',
        'cuti_ver_models.nomorSurat as nomorSurat',
        'cuti_ver_models.verif as verif'
        )
        ->first();

        $tandaTangan = DB::table('users')
        ->where('kabiro','=',1)
        ->select('ttd')
        ->first();

        // $data = $datas
        // ->select('pegawais.*','kgb_ver_models.gajiBaru as gajiBaru','kgb_ver_models.nip as nipVer')
        // ->first();


        // $data = $data->where('nip',$nip);


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template/SK_Cuti.docx');


        $bulanSekarang = Carbon::now()->format('m');

        $cuti = [
            1 => 'Tahunan',
            2 => 'Sakit',
            3 => 'Melahirkan',
            4 => 'Alasan Penting',
            5 => 'di Luar Tanggungan Negara',
            6 => 'Besar'
        ];






        $templateProcessor -> setValues(
            [
                // 'nomorSurat' => $data->noSurat,
                // 'nomorSK' => $data->noSK,
                'nama' => $data->nama_pns,
                'nip' => $data->nip,
                'pangkat' => $data->pangkat .'/'.$data->golru_nm,
                // 'ttl' => $data->tmpt_lahir . ', '. $this->bulan($data->tgl_lahir),
                // .-$bulan[Carbon::parse($data->tgl_lahir)->format('m')].Carbon::parse($data->tgl_lahir)->format('-Y'),
                'jabatan' => ucwords(strtolower($data->jabatan_nm)),
                'unitKerja' => $data->opd_nm,
                'namaBiro' => $data->opd_nm,
                'jenisCuti' => $cuti[$data->jenisCuti],
                // 'gajiLama' => $data->gajiLama,
                // 'gajiBaru' => $data->gajiBaru, /// dari form
                // 'masaKerja' => $data->masa_kerja,
                // 'tanggalUpdate' => $this->bulanUpdate($data->tmt_gaji_N),
                'tanggalMulai' => $this->bulan($data->mulai),
                'tanggalSelesai' => $this->bulan($data->selesai),
                'nomorSurat' => $data->nomorSurat,
                'hariCuti' => $data->hariCuti,
                // 'tanggalMulai' => $data->mulai,
                // 'tanggalSelesai' => $data->selesai,
                'bulanIni' => $this->bulan[$bulanSekarang].Carbon::now()->format(' Y')

                ]
            );

            $ttds = $tandaTangan->ttd;
            if($data->verif == 1){
                if ($tandaTangan && $tandaTangan->ttd) {
                    // Create a temporary file to store the image
                    $tempImagePath = tempnam(sys_get_temp_dir(), 'tempImage') . '.jpg'; // Adjust extension if the image is not JPG

                    file_put_contents($tempImagePath, $tandaTangan->ttd);


                    $templateProcessor->setImageValue('ttd', [
                        'path' => $tempImagePath,
                        'width' => 100, // Specify the width
                        'height' => 100, // Specify the height
                        'ratio' => false // Preserve the aspect ratio if necessary
                    ]);
                }else{
                    $templateProcessor -> setValues(['ttd'=> " "]);
                }
                // $templateProcessor -> setImageValue('ttd', array(
                //     'path' => public_path("/ttd/{$ttds}"),
                //     'width' => 300,
                //     'height' => 200,
                //     'wrappingStyle' => 'infront',
                //     'alignment' => 'center',
                // ));
            }else{
                $templateProcessor -> setValues(['ttd'=> " "]);
            }
            // return null;


            // $nama = $nip;
            // $saveLocation = public_path('php://output');

            header('Content-Disposition: attachment; filename="Surat Cuti_' . $nip .'_'.$data->nama_pns. '.docx"');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        // $savePath = public_path($nama);

// Save the file
            $templateProcessor->saveAs('php://output');
            exit;

        }

    private function bulan($month){

        $tulisan = Carbon::parse($month)->format('d')." ".$this->bulan[Carbon::parse($month)->format('m')]." ".Carbon::parse($month)->format('Y');

        return $tulisan;
    }

    private function bulanUpdate($month){

        $tulisan = Carbon::parse($month)->format('d')." ".$this->bulan[Carbon::parse($month)->format('m')]." ".(Carbon::parse($month)->format('Y')+2);

        return $tulisan;
    }
}
