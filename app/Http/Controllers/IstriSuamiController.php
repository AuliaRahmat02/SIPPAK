<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use App\Models\naikVer2;
use App\Models\IstriSuami;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SuratPengantarVer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;


class IstriSuamiController extends Controller
{
    public function showKartu(){
        if (! Gate::any(["operator", "jft", "kabag", "kabiro"])) {
            return $this->istrisuamiSQL(0);
         }

        if (Gate::allows('operator')) {
            return $this->istrisuamiSQL(1);
         }


         if (Gate::allows('jft')) {

            return $this->istrisuamiSQL(2);
         }


         if (Gate::allows('kabag')) {
             return $this->istrisuamiSQL(3);
         }

         if (Gate::allows('kabiro')) {
             return $this->istrisuamiSQL(4);
         }
    }

    public function istrisuamiSQL($akses){
        $buku = IstriSuami::leftJoin('pegawais','istri_suamis.nip','=','pegawais.nip')
                        ->where('istri_suamis.fase','=',$akses)
                        ->orderBy('pegawais.opd_id')
                        ->get();

        $surat = null;
        if (Auth()->user()->jft==1||Auth()->user()->kabag==1||Auth()->user()->kabiro ==  1) {
            $surat = naikVer2::where('fase','=',$akses)
                                ->where('jenis_surat','=',3)
                                ->get();
        }
        if (Gate::allows('operator')) {
            $surat = naikVer2::where('jenis_surat','=',3)
                                ->get();
        }

        return view('pengantar.kartu',[
            'title'=>'Kartu Istri/Suami',
            'buku'=>$buku,
            'surat'=>$surat,
        ]);
    }

    public function AjukanKartu($nip){
        // dd($nip);
        $p = [
            "nip" => $nip,
            "fase" => 1,
        ];

        $pen = ['kartu'=>true];

        IstriSuami::create($p);
        pegawai::where('nip','=',$nip)->update($pen);
        return back();
    }


    public function P_kartu_op(Request $req){
        $a = $req->validate([
            'nip'=>"required",
            'nama'=>"required",
            'nomor_surat'=>"required|max:10",
        ],[
            "nomor_surat"=>[
                "required"=>'Nomor Surat belum diisi !!',
                "max"=>'Nomor Surat terlalu panjang',
            ],
            "nama"=>[
                "required"=>'Nama Surat belum diisi !!'
            ],
        ]);

        // $pegawai = implode(",",$a['nip']);
        // dd($a);
        $surat = [
            'nomor_surat'=> $a['nomor_surat'],
            'nama_surat'=> $a['nama'],
            'jenis_surat'=> 3, // 1 = kenaikan pangkat
            "fase" => 1
        ];



        if (Gate::allows('operator')) {
           $ambilID =  naikVer2::create($surat);

            foreach ($a['nip'] as $key ) {
                IstriSuami::where('nip','=',$key)->update([
                    'fase'=>2,
                    'surat'=>$ambilID->ID
                ]);
            }
        }
        return back();
    }


    // menghpus permohonan
    public function Hapus_Pemohon($nip){
        $naikver = ['kartu'=>false];

        IstriSuami::where('nip','=',$nip)->delete();
        pegawai::where('nip','=',$nip)->update($naikver);
        return back();
    }

     // menghapus surat permohonan
     public function hapus_surat($id){
        IstriSuami::where('surat','=',$id)->update(['surat'=>null,'fase'=>1]);
        naikVer2::where("ID","=",$id)->delete();
        return back();
    }

    public function verifikasi_kartu($id){
        if (! Gate::any(["operator", "jft", "kabag", "kabiro"])) {
            naikVer2::where('ID','=',$id)->update([
                'fase'=>1,
                'tolak'=>null,
            ]);
        }

        if (Gate::allows('operator')) {
            naikVer2::where('ID','=',$id)->update([
                'fase'=>2,
                'tolak'=>null,
            ]);
        }

        if (Gate::allows('jft')) {
            naikVer2::where('ID','=',$id)->update([
                'fase'=>3,
                'tolak'=>null,
            ]);
        }

        if (Gate::allows('kabag')) {
            naikVer2::where('ID','=',$id)->update([
                'fase'=>4,
                'tolak'=>null,
            ]);
        }
        if (Gate::allows('kabiro')) {
            $tanggal = Carbon::now();
            naikVer2::where('ID','=',$id)->update([
                'fase'=>5,
                'tolak'=>null,
                'tanggal'=> $tanggal
            ]);
            IstriSuami::where("surat",'=',$id)->update([
                'fase'=>3
            ]);
        }
        return back();
    }

    public function kembali($id){
        $jenis = naikVer2::where('ID','=',$id)->first();

        if($jenis->jenis_surat == 1){
            return redirect('/kenaikanpangkat');
        }
        if($jenis->jenis_surat == 2){
            return redirect('/pensiun');
        }
        if($jenis->jenis_surat == 3){
            return redirect('/kartu');
        }
        if($jenis->jenis_surat == 4){
            return redirect('/belajar');
        }
        if($jenis->jenis_surat == 5){
            return redirect('/ijazah');
        }
        if($jenis->jenis_surat == 6){
            return redirect('/satyalencana');
        }
    }


    //MENAMPILKAN SURAT YANG TELAH DIBUAT
    public function SuratRekap(){
        $tahunini = Carbon::now()->year;
        $surat = SuratPengantarVer::selectRaw("nama_surat,nomor_surat,id_surat,DATE_FORMAT(created_at, '%d %M %Y') AS tanggal")
                                        ->where('jenis',"=",3)
                                        ->whereRaw('YEAR(created_at) = ?',[$tahunini])
                                        ->get();
        return view("pengantar.suratRekap",[
            "title"=> "Download Surat Pengantar",
            "judul"=> "KARTU SUAMI / KARTU ISTRI",
            "surat"=>$surat
        ]);
    }
}
