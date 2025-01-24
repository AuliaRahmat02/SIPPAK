<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pegawai;
use App\Models\naikVer2;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\fileModel;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    protected $adpim = 'BIRO ADMINISTRASI PIMPINAN';

    public function index()
    {
        $naik = NaikPangkatController::naiknotif($this->adpim);
        $naikkgb = KgbController::naikgaji();

        $pengantar = null;
        if (Gate::allows('jft')) {
            $pengantar = $this->NotifPengantar(2);
        }


        if (Gate::allows('kabag')) {
            $pengantar = $this->NotifPengantar(3);
        }

        if (Gate::allows('kabiro')) {
            $pengantar = $this->NotifPengantar(4);
        }
        // dd($pengantar);
        return view('dash.dashboard', [
            'title'=>'Dashboard',
            'naik'=> $naik,
            'naikkgb'=> $naikkgb,
            'pengantar'=> $pengantar,
            // 'KGB'=>$kgb,
        ]);
    }

    public function operator(){
        $naikkgb = KgbController::naikgaji();
        $kenaikan = NaikPangkatController::kenaikanpangkatnotif(1);
        $user = $this->pegawai($this->adpim);
        return view('dash.dashboard',[
            'title'=>'Administrasi Pimpinan',
            'naikkgb'=> $naikkgb,
            'data'=> $user,
            "kenaikan"=>$kenaikan,
        ]);
    }

    public function adpim(){
        $naik = NaikPangkatController::naiknotif($this->adpim);
        $user = $this->pegawai($this->adpim);
        // dd($user);
        return view('dash.adpim',[
            'title'=>'Administrasi Pimpinan',
            'data'=> $user,
            'naik'=> $naik,
        ]);

        // $user = DB::table('pegawais')
        // ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60))")
        //             ->where('opd_nm', $this->adpim)
        //             ->orderBy('golru_id', 'desc')
        //             ->get();
        // return view('dash.adpim',[
        //     'title'=>'Administrasi Pimpinan',
        //     'data'=> $user,
        // ]);
    }

    public function organisasi(){
        $biro = "BIRO ORGANISASI";
        $naik = NaikPangkatController::naiknotif($biro);
        $user = $this->pegawai($biro);
        // dd($user);
        return view('dash.organisasi',[
            'title'=>'Organisasi',
            'data'=> $user,
            'naik'=> $naik,
        ]);
    }


    public function pemotonom(){
        $biro = "BIRO PEMERINTAHAN DAN OTONOMI DAERAH";
        $naik = NaikPangkatController::naiknotif($biro);
        $tahunIni = Carbon::now()->year;
        $user = $this->pegawai($biro);

        return view('dash.otonom',[
            'title'=>'PEMERINTAHAN DAN OTONOMI DAERAH',
            'data'=> $user,
            'naik'=> $naik,
        ]);
    }

    public function perekonomian(){
        $biro = "BIRO PEREKONOMIAN";
        $naik = NaikPangkatController::naiknotif($biro);
        $tahunIni = Carbon::now()->year;
        $user = $this->pegawai($biro);
        // dd($user);
        return view('dash.perekonomian',[
            'title'=>'PEREKONOMIAN',
            'data'=> $user,
            'naik'=> $naik,
        ]);
    }


    public function hukum(){
        $biro = "BIRO HUKUM";
        $naik = NaikPangkatController::naiknotif($biro);
        $tahunIni = Carbon::now()->year;
        $user = $this->pegawai($biro);
        // dd($user);
        return view('dash.hukum',[
            'title'=>'HUKUM',
            'data'=> $user,
            'naik'=> $naik,
        ]);
    }

    public function kesra(){
        $biro = "BIRO KESEJAHTERAAN RAKYAT";
        $naik = NaikPangkatController::naiknotif($biro);
        $user = $this->pegawai($biro);

        return view('dash.kesra',[
            'title'=>'KESEJAHTERAAN RAKYAT',
            'data'=> $user,
            'naik'=>$naik
        ]);
    }

    public function adpem(){
        $biro= 'BIRO ADMINISTRASI PEMBANGUNAN';
        $naik = NaikPangkatController::naiknotif($biro);
        $user = $this->pegawai($biro);

        return view('dash.adpem',[
            'title'=>'ADMINISTRASI PEMBANGUNAN',
            'naik'=> $naik,
            'data'=> $user,
        ]);
    }

    public function barangjasa(){
        $naik = NaikPangkatController::naiknotif("BIRO PENGADAAN BARANG DAN JASA");
        $user = $this->pegawai("Biro Pengadaan Barang dan Jasa");
        // dd($user);
        return view('dash.barangjasa',[
            'title'=>'PENGADAAN BARANG DAN JASA',
            'naik'=> $naik,
            'data'=> $user,
        ]);
    }
    public function umum(){
        $biro = 'BIRO UMUM';
        $naik = NaikPangkatController::naiknotif($biro);

        $user = $this->pegawai($biro);
        return view('dash.umum',[
            'title'=>'UMUM',
            'naik'=> $naik,
            'data'=> $user,
        ]);
    }


    public function pegawai($biro){
        $user = DB::table('pegawais')
                    ->whereRaw("(((((jns_jbtn_id = 1 AND usia <= 58) OR ((jns_jbtn_id = 2 AND eselon_id <= 22) AND usia <= 60)) OR ((jns_jbtn_id = 2 AND eselon_id > 22) AND usia <= 58) OR ((jns_jbtn_id = 3 AND jenjang_id <= 06) AND usia <= 58))) OR ((jns_jbtn_id = 3 AND jenjang_id >= 07) AND usia <= 60)) ")
                    ->where('opd_nm','=', $biro)
                    ->orderBy('golru_id', 'desc')
                    ->get();
        return $user;
    }

    public function showPengantar(){
        return view('pengantar.pengantar',[
            'title'=> 'Surat Pengantar'
        ]);
    }





    // =========================================NOTIFIKASI SURAT PENGANTAR==========================================
    public function NotifPengantar($akses){
        $kartu = naikVer2::where('fase','=',$akses)->where('jenis_surat','=',3)->count();
        $naik = naikVer2::where('fase','=',$akses)->where('jenis_surat','=',1)->count();
        $belajar = naikVer2::where('fase','=',$akses)->where('jenis_surat','=',4)->count();
        $ijazah = naikVer2::where('fase','=',$akses)->where('jenis_surat','=',5)->count();
        $pensiun = naikVer2::where('fase','=',$akses)->where('jenis_surat','=',2)->count();
        $sat = naikVer2::where('fase','=',$akses)->where('jenis_surat','=',6)->count();

        $notif = [
            "kartu"=>[
                'link'=>'/kartu',
                "nama"=>'Kartu Suami / Kartu Istri',
                "surat"=>$kartu
            ],
            "naikpangkat"=>[
                'link'=>'/kenaikanpangkat',
                "nama"=>'Pengurusan Kenaikan Pangkat',
                "surat"=>$naik
            ],
            "belajar"=>[
                'link'=>'/belajar',
                "nama"=>'Pemberian Izin Belajar',
                "surat"=>$belajar
            ],
            "ijazah"=>[
                'link'=>'/ijazah',
                "nama"=>'Penysuaian Ijazah / Pemakaian Gelar',
                "surat"=>$ijazah
            ],
            "pensiun"=>[
                'link'=>'/pensiun',
                "nama"=>'Pengurusan Pensiun',
                "surat"=>$pensiun
            ],
            "sat"=>[
                'link'=>'/satyalencana',
                "nama"=>'Usulan Satyalencana Karya Satya',
                "surat"=>$sat
            ],
        ];

        return $notif;
    }



    // ===========PROFIL PEGAWAI===================================

    public function ProfilPegawai($nip){

        $dataProfil = pegawai::where('nip','=',$nip)->first();
        $BahanPengantar = fileModel::where('nip_pegawai','=',$nip)->get();
        $dataCuti = DB::table('cuti_ups')->where('nip','=',$nip)->get();

        
        return view('dash.profil',[
            'title'=>'Data Pegawai',
            'datacuti'=>$dataCuti,
            'surat'=>$BahanPengantar,
            "data" => $dataProfil
        ]);
    }

    public function uploadBahan(Request $res){
        $res->validate([
            'nip'=>"required|max:18|min:18",
            'jenisBahan'=>"required",
            'nama'=>"required",
            'file'=>"required|mimes:pdf"
        ],[
            "file"=>[
                "required"=>"File PDF Belum di inputkan",
                "mimes"=>"File yang dimasukkan harus dengan format PDF"
            ],
            "jenisBahan"=>[
                "required"=>"Pilih jenis Surat yang akan dimasukkan"
            ]
        ]);

        $jenisSurat=[
            1 => "surat Kenaikan pangkat",
            2 => "surat Pensiun",
            3 => "Kartu isteri/suami",
            4 => "surat Permohonan izin Belajar",
            5 => "surat ijazah dan pemakaian gelar",
            6 => "surat penghargaan satyalencana",
        ];

        $file = $res->file('file');
        $fileName = $jenisSurat[$res->jenisBahan]."_". $res->nama;
        $fileData = file_get_contents($file->getRealPath()); // Baca isi file sebagai binary


        fileModel::updateOrCreate(
            [
                "nip_pegawai" => $res['nip'],
                "jenisBahan" => $res["jenisBahan"],                    
            ],[
                "nama" => $fileName,
                "file" => $fileData,
            ]
        );
        return back();
    }

    public function viewPdf($id)
    {
        // Find the file by its ID
        $file = fileModel::where('ID',"=", $id)
        ->first(); // Adjust to match your actual table structure


        // Get the binary PDF data
        $pdfData = $file->file; // Assuming the binary data is stored in 'file_data'

        // Return the PDF as a response
        return response($pdfData, 200)
            ->header('Content-Type', 'application/pdf')  // Set PDF content type
            ->header('Content-Disposition', 'inline; filename="document.pdf"');  // Inline means it will be displayed in the browser
    }
}
