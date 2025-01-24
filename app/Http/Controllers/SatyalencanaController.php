<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pegawai;
use App\Models\naikVer2;
use App\Models\Satyalencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\SuratPengantarVer;

class SatyalencanaController extends Controller
{
    public function showSatya(){
        if (! Gate::any(["operator", "jft", "kabag", "kabiro"])) {
            return $this->satyaSQL(0);
        }

        if (Gate::allows('operator')) {
            return $this->satyaSQL(1);
        }

        if (Gate::allows('jft')) {

        return $this->satyaSQL(2);
        }


        if (Gate::allows('kabag')) {
            return $this->satyaSQL(3);
        }

        if (Gate::allows('kabiro')) {
            return $this->satyaSQL(4);
        }


    }

    public function satyaSQL($akses){
        $buku = DB::table('satyalencanas')->leftJoin('pegawais','satyalencanas.nip','=','pegawais.nip')
                        ->where('satyalencanas.fase','=',$akses)
                        ->orderBy('pegawais.opd_id')
                        ->get();

        $surat = null;
        if (Gate::any(["kabag","jft","kabiro"])) {
            $surat = naikVer2::where('fase','=',$akses)
                                ->where('jenis_surat','=',6)
                                ->get();
        }
        if (Gate::allows('operator')) {
            $surat = naikVer2::where('jenis_surat','=',6)
                                ->get();
        }

        return view('pengantar.satyalencana',[
            'title'=>'Satyalencana',
            'buku'=>$buku,
            'surat'=>$surat,
        ]);
    }

    public function AjukanSat($nip){
        // dd($nip);
        $p = [
            "nip" => $nip,
            "fase" => 1,
        ];

        $pen = ['satyalencana'=>true];

        Satyalencana::create($p);
        pegawai::where('nip','=',$nip)->update($pen);
        return back();
    }


    // menghpus permohonan
    public function Hapus_Pemohon($nip){
        $naikver = ['satyalencana'=>false];

        Satyalencana::where('nip','=',$nip)->delete();
        pegawai::where('nip','=',$nip)->update($naikver);
        return back();
    }

    // fungsi untuk mengirim notif ke bagian jft adpim
    public function P_Sat_op(Request $req){
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

        // dd($a);
        $surat = [
            'nomor_surat'=> $a['nomor_surat'],
            'nama_surat'=> $a['nama'],
            'jenis_surat'=> 6, // 6 = Satyalencana
            "fase" => 1
        ];



        if (Gate::allows('operator')) {
           $ambilID =  naikVer2::create($surat);

            foreach ($a['nip'] as $key ) {
                Satyalencana::where('nip','=',$key)->update([
                    'fase'=>2,
                    'surat'=>$ambilID->ID
                ]);
            }
        }

        return back();
    }

    // menghapus surat permohonan
    public function hapus_surat($id){
        Satyalencana::where('surat','=',$id)->update(['surat'=>null,'fase'=>1]);
        naikVer2::where("ID","=",$id)->delete();
        return back();
    }

    public function verifikasi_sat($id){
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
            Satyalencana::where("surat",'=',$id)->update([
                'fase'=>3
            ]);
        }
        return back();
    }
    //MENAMPILKAN SURAT YANG TELAH DIBUAT
    public function SuratRekap(){
        $tahunini = Carbon::now()->year;
        $surat = SuratPengantarVer::selectRaw("nama_surat,nomor_surat,id_surat,DATE_FORMAT(created_at, '%d %M %Y') AS tanggal")
                                        ->where('jenis',"=",6)
                                        ->whereRaw('YEAR(created_at) = ?',[$tahunini])
                                        ->get();
        return view("pengantar.suratRekap",[
            "title"=> "Download Surat Pengantar",
            "judul"=> "USULAN SATYALENCANA KARYA SATYA",
            "surat"=>$surat
        ]);
    }
}
