<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pegawai;
use App\Models\naikVer2;
use App\Models\IjazahGelar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SuratPengantarVer;
use Illuminate\Support\Facades\Gate;


class IjazahGelarController extends Controller
{
    public function showIjazah(){
        if (! Gate::any(["operator", "jft", "kabag", "kabiro"])) {
            return $this->ijazahSQL(1);
        }

        if (Gate::allows('operator')) {
            return $this->ijazahSQL(1);
        }

        if (Gate::allows('jft')) {

            return $this->ijazahSQL(2);
        }


        if (Gate::allows('kabag')) {
            return $this->ijazahSQL(3);
        }

        if (Gate::allows('kabiro')) {
            return $this->ijazahSQL(4);
        }


    }

    public function ijazahSQL($akses){
        $buku = IjazahGelar::leftJoin('pegawais','ijazah_gelars.nip','=','pegawais.nip')
                        ->where('ijazah_gelars.fase','=',$akses)
                        ->orderBy('pegawais.opd_id')
                        ->get();

        $surat = null;
        if (Gate::any(["kabag","jft","kabiro"])) {
            $surat = naikVer2::where('fase','=',$akses)
                                ->where('jenis_surat','=',5)
                                ->get();
        }
        if (Gate::allows('operator')) {
            $surat = naikVer2::where('jenis_surat','=',5)
                                ->get();
        }

        return view('pengantar.ijazah',[
            'title'=>'Ijazah dan Gelar',
            'buku'=>$buku,
            'surat'=>$surat,
        ]);
    }


    public function AjukanIjazah($nip){
        // dd($nip);
        $p = [
            "nip" => $nip,
            "fase" => 1,
        ];

        $pen = ['ijazah'=>true];

        IjazahGelar::create($p);
        pegawai::where('nip','=',$nip)->update($pen);
        return back();
    }

    // menghpus permohonan
    public function Hapus_Pemohon($nip){
        $naikver = ['ijazah'=>false];

        IjazahGelar::where('nip','=',$nip)->delete();
        pegawai::where('nip','=',$nip)->update($naikver);
        return back();
    }


    // fungsi untuk mengirim notif ke bagian jft adpim
    public function P_Ijazah_op(Request $req){
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
            'jenis_surat'=> 5, // 5 = iajazah dan gelar
            "fase" => 1
        ];



        if (Gate::allows('operator')) {
           $ambilID =  naikVer2::create($surat);

            foreach ($a['nip'] as $key ) {
                IjazahGelar::where('nip','=',$key)->update([
                    'fase'=>2,
                    'surat'=>$ambilID->ID
                ]);
            }
        }

        return back();
    }

    // menghapus surat permohonan
    public function hapus_surat($id){
        IjazahGelar::where('surat','=',$id)->update(['surat'=>null,'fase'=>1]);
        naikVer2::where("ID","=",$id)->delete();
        return back();
    }

    public function verifikasi_ijazah($id){
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
            IjazahGelar::where("surat",'=',$id)->update([
                'fase'=>3
            ]);
        }
        return back();
    }

    //MENAMPILKAN SURAT YANG TELAH DIBUAT
    public function SuratRekap(){
        $tahunini = Carbon::now()->year;
        $surat = SuratPengantarVer::selectRaw("nama_surat,nomor_surat,id_surat,DATE_FORMAT(created_at, '%d %M %Y') AS tanggal")
                                        ->where('jenis',"=",5)
                                        ->whereRaw('YEAR(created_at) = ?',[$tahunini])
                                        ->get();
        return view("pengantar.suratRekap",[
            "title"=> "Download Surat Pengantar",
            "judul"=> "PENYESUAIAN IJAZAH DAN PEMAKAIAN GELAR",
            "surat"=>$surat
        ]);
    }
}
