<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pegawai;
use App\Models\Pensiun;
use App\Models\naikVer2;
use App\Models\RekapPensiun;
use Illuminate\Http\Request;
use App\Exports\PensiunExport;
use App\Models\SuratPengantarVer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class PensiunController extends Controller
{
    public function showPensiun(){
        if (! Gate::any(["operator", "jft", "kabag", "kabiro"])) {
            return $this->pensiunSQL(0);
        }

        if (Gate::allows('operator')) {
            return $this->pensiunSQL(1);
        }


        if (Gate::allows('jft')) {

        return $this->pensiunSQL(2);
        }


        if (Gate::allows('kabag')) {
            return $this->pensiunSQL(3);
        }

        if (Gate::allows('kabiro')) {
            return $this->pensiunSQL(4);
        }


    }

    public function pensiunSQL($akses){
        $buku = Pensiun::leftJoin('pegawais','pensiuns.nip','=','pegawais.nip')
                        ->where('pensiuns.fase','=',$akses)
                        ->get();
        $surat = null;
        $period = $this->periode();
        $per = $this->periode_naik();

        if (Gate::any(["kabag","jft","kairo"])) {
            $surat = naikVer2::where('periode','=',$per)
                                ->where('fase','=',$akses)
                                ->where('jenis_surat','=',2)
                                ->get();
        }
        if (Gate::allows('operator')) {
            $surat = naikVer2::where('periode','=',$per)
                                ->where('jenis_surat','=',2)
                                ->get();
        }

        return view('pengantar.pensiun',[
            'title'=>'Surat Pensiun',
            'buku'=>$buku,
            'periode'=>$period,
            'surat'=>$surat,
        ]);
    }

    public function AjukanPensiun($nip){
        // dd($nip);
        $p = [
            "nip" => $nip,
            "fase" => 1,
        ];

        $pen = ['pensiun'=>true];

        Pensiun::create($p);
        pegawai::where('nip','=',$nip)->update($pen);
        return back();
    }

    // menentukan periode kenaikan pangkat
    public static function periode_naik(){
        $bulanIni = Carbon::now()->month;
        if (($bulanIni > 4) && ($bulanIni<11)) {
            return 2;
        } else {
            return 2;
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

    // menghpus permohonan
    public function Hapus_Pemohon($nip){
        $naikver = ['pensiun'=>false];

        Pensiun::where('nip','=',$nip)->delete();
        pegawai::where('nip','=',$nip)->update($naikver);
        return back();
    }

    // fungsi untuk mengirim notif ke bagian jft adpim
    public function P_Pensiun_op(Request $req){
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
        $periode = $this->periode_naik();
        // dd($a);
        $surat = [
            'nomor_surat'=> $a['nomor_surat'],
            'nama_surat'=> $a['nama'],
            'jenis_surat'=> 2, // 2 = Surat Pengantar Pensiun
            "periode" => $periode,
            "fase" => 1
        ];



        if (Gate::allows('operator')) {
           $ambilID =  naikVer2::create($surat);

            foreach ($a['nip'] as $key ) {
                Pensiun::where('nip','=',$key)->update([
                    'fase'=>2,
                    'surat'=>$ambilID->ID
                ]);
            }
        }

        return back();
    }

    // menghapus surat permohonan
    public function hapus_surat($id){
        Pensiun::where('surat','=',$id)->update(['surat'=>null,'fase'=>1]);
        naikVer2::where("ID","=",$id)->delete();
        return back();
    }


    public function verifikasi_pensiun($id){
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
            Pensiun::where("surat",'=',$id)->update([
                'fase'=>3
            ]);
        }
        return back();
    }

    // menampilkan rekapitulasi Pensiun
    public function Pensiun_Rekapitulasi(){
        $periode = $this->periode_naik();
        $tahunini = Carbon::now()->year;
        $pegawai = RekapPensiun::leftjoin("pegawais","pegawais.nip","=","rekap_pensiuns.nip")
                                        ->where('periode',"=",$periode)
                                        ->whereRaw('YEAR(rekap_pensiuns.created_at) = ?',[$tahunini])
                                        ->get();
        return view("pengantar.RekapPEN",[
            "title"=> "Rekapitulasi Pensiun",
            "judul"=> "PENSIUN",
            "pegawai"=>$pegawai,
            "semester"=>$periode
        ]);
    }


    //MENAMPILKAN SURAT YANG TELAH DIBUAT
    public function SuratRekap(){
        $tahunini = Carbon::now()->year;
        $surat = SuratPengantarVer::selectRaw("nama_surat,nomor_surat,id_surat,DATE_FORMAT(created_at, '%d %M %Y') AS tanggal")
                                        ->where('jenis',"=",2)
                                        ->whereRaw('YEAR(created_at) = ?',[$tahunini])
                                        ->get();
        return view("pengantar.suratRekap",[
            "title"=> "Download Surat Pengantar",
            "judul"=> "PENSIUN",
            "surat"=>$surat
        ]);
    }


    public function ExPensiun(){
        return Excel::download(new PensiunExport,"Rekapitulasi Pensiun.xlsx");
    }
}
