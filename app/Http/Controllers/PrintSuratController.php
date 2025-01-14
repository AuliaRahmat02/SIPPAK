<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\users;
use App\Models\naikVer2;
use App\Models\SuratPengantarVer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\pegawai;
use App\Models\RekapNaikPangkat;
use App\Models\RekapPensiun;
use Illuminate\Support\Facades\Response;



header('Content-Description: File Transfer');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');


// require_once 'vendor/autoload.php';

class PrintSuratController extends Controller
{

    public static function SpNaikPangkat($id_surat){


        // menentukan surat apa yang akan dibuat
        $surat = naikVer2::where('ID',"=",$id_surat)->first();
        $not = '';
        $tabel = "";
        $NamaSurat = $surat->nama_surat;
        $temlateSurat = "";
        switch ($surat->jenis_surat) {
            case 1:
                // menentukan nama tabel berdasarkan jenis surat yang akan dibuat
                $tabel ="naik_ver_models";

                // menentukan notifikasi pada table pegawai
                $not = "naik";

                // menetukan file surat
                $temlateSurat = "naikpangkat";
                break;
            case 2:
                // menentukan nama tabel berdasarkan jenis surat yang akan dibuat
                $tabel ="pensiuns";

                // menentukan notifikasi pada table pegawai
                $not = "pensiun";

                // menetukan file surat
                $temlateSurat = "pensiun";
                break;
            case 3:
                // menentukan nama tabel berdasarkan jenis surat yang akan dibuat
                $tabel ="istri_suamis";

                // menentukan notifikasi pada table pegawai
                $not = "kartu";

                // menetukan file surat
                $temlateSurat = "kartu";
                break;
            case 4:
                // menentukan nama tabel berdasarkan jenis surat yang akan dibuat
                $tabel ="belajars";

                // menentukan notifikasi pada table pegawai
                $not = "belajar";

                // menetukan file surat
                $temlateSurat = "belajar";
                break;
            case 5:
                // menentukan nama tabel berdasarkan jenis surat yang akan dibuat
                $tabel ="ijazah_gelars";

                // menentukan notifikasi pada table pegawai
                $not = "ijazah";

                // menetukan file surat
                $temlateSurat = "ijazah";
                break;
            case 6:
                // menentukan nama tabel berdasarkan jenis surat yang akan dibuat
                $tabel ="satyalencanas";

                // menentukan notifikasi pada table pegawai
                $not = "satyalencana";

                // menetukan file surat
                $temlateSurat = "satya";
                break;
        }

        // mengambil nama pegawai berdasarkan id suart yang akan dibuat untuk dimasukkan ke dalam surat
        $pegawais = DB::table($tabel)
                        ->leftjoin('pegawais',$tabel.'.nip','=','pegawais.nip')
                        ->select('pegawais.nama_pns','pegawais.nip','pegawais.opd_nm','pegawais.golru_pns','pegawais.jabatan_nm')
                        ->where($tabel.'.surat','=',$id_surat)
                        ->get();


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template/'.$temlateSurat.'.docx');

        $tanggal = "";



        // memasukkan nomor surat
        $templateProcessor->setValue('nomor_surat', $surat->nomor_surat);
        $templateProcessor->cloneRow('nama', count($pegawais));

        $ttd = "";
        $no = 1;


        // memasukkan nama ke dalam table yang ada di word
        foreach ($pegawais as $index=>$p) {
            $templateProcessor->setValue('no#' . ($index + 1), $no);
            $templateProcessor->setValue('nama#' . ($index + 1), $p->nama_pns);
            $templateProcessor->setValue('nip#' . ($index + 1), $p->nip);
            $templateProcessor->setValue('pangkat#' . ($index + 1), $p->golru_pns);
            $templateProcessor->setValue('jabatan#' . ($index + 1), $p->jabatan_nm);
            $templateProcessor->setValue('unit_kerja#' . ($index + 1), $p->opd_nm);
            $no++;
        }

        if (($surat->tanggal != null)&&($surat->fase == 5)) {
            $tanggal = Carbon::parse($surat->tanggal)->locale('id')->isoFormat("D MMMM YYYY");
            $ttd = users::select("ttd")->where('kabiro','=',1)->first();

            // memasukkan tanggal surat ditanda tangani
            $templateProcessor->setValue('tanggal', $tanggal);


            if($ttd->ttd != null){
                // membuat format gambar menjadi jpg
                $tempImagePath = tempnam(sys_get_temp_dir(), 'tempImage') . '.jpg';

                // menggabungkan file gambar dengan nama dan format yang telah dibuat
                file_put_contents($tempImagePath, $ttd->ttd);

                // memasukkan dan meletakkan file gambar ke dalam word berdasarkan letak variabel yang ada di word
                $templateProcessor->setImageValue('ttd', [
                    'path' => $tempImagePath,
                    'width' => 100, // menentukan lebar dari gambar
                    'height' => 100, // menentukan tinggi gamabar
                    'ratio' => false // menentukan rasio gambar
                ]);
            }else{
                $ttd = "";
                $templateProcessor->setValue('ttd', $ttd);
            }



            // mengubah file word yang telah di buat ke dalam bentuk binary
            ob_start();
            $templateProcessor->saveAs('php://output');
            $binaryContent = ob_get_clean();

            // memasukkan file word ke dalam database agar bisa di cetak kembali
            $ID_surat =SuratPengantarVer::create([
                'nama_surat'=>$NamaSurat,
                'nomor_surat'=>$surat->nomor_surat,
                'jenis'=>$surat->jenis_surat,
                'file'=>$binaryContent,
            ]);



            // menentukan jenis surat yang akan dimasukkan ke perekapan REKAPITULASI
            if ($surat->jenis_surat == 1) {
                $nips = DB::table($tabel)->select('nip')->where('surat',"=",$id_surat)->get();
                foreach ($nips as $i) {
                    // mengubah notifikasi di tabel pegawai
                    pegawai::where('nip',"=",$i->nip)->update([$not=>false]);

                    // memasukkan nama pegawai ke dalam rekapan naik pangkat
                    RekapNaikPangkat::create([
                                "nip"=>$i->nip,
                                "periode"=>$surat->periode,
                            ]);
                }
            }else if ($surat->jenis_surat == 2) {
                $nips = DB::table($tabel)->select('nip')->where('surat',"=",$id_surat)->get();
                foreach ($nips as $i) {
                    // mengubah notifikasi di table pegawai
                    pegawai::where('nip',"=",$i->nip)->update([$not=>false]);

                    // memasukkan nama pegawai ke dalam rekapan pensiun
                    RekapPensiun::create([
                                "nip"=>$i->nip,
                                "periode"=>$surat->periode
                            ]);
                }
            }else{
                $nips = DB::table($tabel)->select('nip')->where('surat',"=",$id_surat)->get();
                foreach ($nips as $i) {
                    // mengubah notifikasi di tabel pegawai
                    pegawai::where('nip',"=",$i->nip)->update([$not=>false]);
                }
            }


            // menghapus surat dari table sementara
            naikVer2::where('id',"=",$id_surat)->delete();

            return redirect("/DownloadSurat/{$ID_surat->id_surat}");
        }else{
            $templateProcessor->setValue('ttd', $ttd);
            // DIBAWAH INI MERUPAKAN SINTAKS UNTUK MELAKUKAN DOWNLOAD PADA BROWSER
            header('Content-Disposition: attachment; filename='.$NamaSurat.'.docx');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

            $templateProcessor->saveAs('php://output');
            exit;
        }
    }





    public function LoadSuratPengantar($id)
    {
        // Ambil file dari database berdasarkan ID
        $document = SuratPengantarVer::where('id_surat', $id)->first();

        $fileName = $document->nama_surat.'.docx';
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return Response::make($document->file, 200, $headers);
    }
}
