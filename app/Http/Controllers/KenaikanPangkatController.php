<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pegawai;
use App\Models\naikVer2;
use App\Exports\NaikExport;
use App\Models\NaikVerModel;
use Illuminate\Http\Request;
use App\Models\RekapNaikPangkat;
use App\Models\SuratPengantarVer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class KenaikanPangkatController extends Controller
{
     // tampilan kenaikan pangkat
     public function KenaikanPangkat(){
        if (! Gate::any(["operator", "jft", "kabag", "kabiro"])) {
           return $this->KenaikanPangkatSQL(1);
        }

        if (Gate::allows('operator')) {
           return $this->KenaikanPangkatSQL(1);
        }

        if (Gate::allows('jft')) {
           return $this->KenaikanPangkatSQL(2);
        }

        if (Gate::allows('kabag')) {
            return $this->KenaikanPangkatSQL(3);
        }

        if (Gate::allows('kabiro')) {
            return $this->KenaikanPangkatSQL(4);
        }

    }


    // menentukan periode kenaikan pangkat
    public static function periode(){
        $bulanIni = Carbon::now()->month;
        if (($bulanIni > 4) && ($bulanIni<11)) {
            return 'OKTOBER';
        } else {
            return 'APRIL';
        }

    }

    // sql untuk kenaikan pangkat
    public function KenaikanPangkatSQL($akses){

        $surat = null;
        $buku = null;
        $period = $this->periode();
        $per = $this->periode_naik();

        if (Auth()->user()->jft==1||Auth()->user()->kabag==1||Auth()->user()->kabiro ==  1) {
            $surat = naikVer2::
                                where('fase','=',$akses)
                                ->where('jenis_surat','=',1)
                                ->get();
        }
        if (Gate::allows('operator')) {
            $surat = naikVer2::where('periode','=',$per)
                                ->where('jenis_surat','=',1)
                                ->get();

            $buku = NaikVerModel::leftJoin('pegawais','naik_ver_models.nip','=','pegawais.nip')
                                ->where('naik_ver_models.fase','=',$akses)
                                ->get();
        }

        return view('pengantar.kenaikanpangkat',[
            'title'=>'Kenaikan Pangkat',
            'buku'=>$buku,
            'periode'=>$period,
            'surat'=>$surat,
        ]);
    }


    // preview surat kenaikan pangkat
    public function preview_surat($id_surat){

        $surat = PrintSuratController::SpNaikPangkat($id_surat);
        return $surat;
    }

    public function verifikasi_naik($id){
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
            NaikVerModel::where("surat",'=',$id)->update([
                'fase'=>3
            ]);
        }
        return back();
    }

    public function tolak_show($id){
        return view("pengantar.formtolaksurat",[
            "tolak"=>$id,
            "title"=>"Tolak Surat"
        ]);
    }

    public function tolak_surat(Request $req){
        $ver = $req->validate([
            'id'=>"required",
            'pesan'=>"required",
        ]);

        // dd($ver);
        naikVer2::where('ID','=',$ver["id"])->update([
            'fase'=>1,
            'tolak'=>$ver["pesan"],
        ]);

        $jenis = naikVer2::where('ID','=',$ver['id'])->first();

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


    public function perbaiki_show($id){
        return view("pengantar.formEditsurat",[
            "tolak"=>$id,
            "title"=>"Perbaiki Surat"
        ]);
    }

    public function perbaiki(Request $req){
        $ver = $req->validate([
            'id'=>"required",
            'nomor_surat'=>"required|max:10",
            'nama_surat'=>"required",
        ]);

        // dd($ver);
        naikVer2::where('ID','=',$ver["id"])->update([
            'nomor_surat'=>$ver["nomor_surat"],
            'nama_surat'=>$ver["nama_surat"],
        ]);

        $jenis = naikVer2::where('ID','=',$ver['id'])->first();

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

    // menentukan periode kenaikan pangkat
    public static function periode_naik(){
        $bulanIni = Carbon::now()->month;
        if ($bulanIni <= 6) {
            return 1;
        } else {
            return 2;
        }

    }

    // menghapus surat permohonan
    public function hapus($id){
        NaikVerModel::where('surat','=',$id)->update(['surat'=>null,'fase'=>1]);
        naikVer2::where("ID","=",$id)->delete();
        return back();
    }


    // menampilkan rekapitulasi kenaikan pangkat
    public function Naik_Rekapitulasi(){
        $periode = $this->periode_naik();
        $tahunini = Carbon::now()->year;
        $pegawai = RekapNaikPangkat::leftjoin("pegawais","pegawais.nip","=","rekap_naik_pangkats.nip")
                                        ->where('periode',"=",$periode)
                                        ->whereRaw('YEAR(rekap_naik_pangkats.created_at) = ?',[$tahunini])
                                        ->get();
        return view("pengantar.RekapNP",[
            "title"=> "Rekapitulasi Naik Pangkat",
            "judul"=> "KENAIKAN PANGKAT",
            "pegawai"=>$pegawai,
            "semester"=>$periode
        ]);
    }


    //MENAMPILKAN SURAT YANG TELAH DIBUAT
    public function SuratRekap(){
        $tahunini = Carbon::now()->year;
        $surat = SuratPengantarVer::selectRaw("nama_surat,nomor_surat,id_surat,DATE_FORMAT(created_at, '%d %M %Y') AS tanggal")
                                        ->where('jenis',"=",1)
                                        ->whereRaw('YEAR(created_at) = ?',[$tahunini])
                                        ->get();
        return view("pengantar.suratRekap",[
            "title"=> "Download Surat Pengantar",
            "judul"=> "Kenaikan Pangkat",
            "surat"=>$surat
        ]);
    }

    public function ExKenakikanPangkat(){
        return Excel::download(new NaikExport,"Kenaikan Pankgat.xlsx");
    }
}
