<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\history;
use App\Models\pegawai;
use App\Exports\CutiExport;
use Illuminate\Http\Request;
use App\Models\cuti_ver_model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;


class CutiController extends Controller
{
    private $months = [
        "" => 'Semua Bulan',
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
    ];

    public function export_cuti(){
        return Excel::download(new CutiExport,"RekapitulasiCuti.xlsx");
    }



    public function rekapCuti(){
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;


            $data = DB::table('pegawais')
            ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
            ->select('pegawais.*',
            'cuti_ver_models.fase as fase',
            'cuti_ver_models.verif as verif',
            'cuti_ver_models.pesan as pesan',
            'cuti_ver_models.mulai as mulai',
            'cuti_ver_models.selesai as selesai')
            ->where('verif',1);



        $items = $data;






        // else{
        //     $data = DB::table('pegawais')
        //     ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
        //     ->select('pegawais.*',
        //     'cuti_ver_models.fase as fase')
        //     ->where('fase',0)
        //     ->get();
        // }

        // $data = cuti::all();

        // dd($data);

        $items= $items->get();

        return view("cuti.rekapcuti",[
            "title"=>'Cuti',
            "data"=>$items,
        ]);
    }


    public function show(Request $request){
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;


        if(Gate::allows('jft')){
            $data = DB::table('pegawais')
            ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
            ->select('pegawais.*',
            'cuti_ver_models.fase as fase',
            'cuti_ver_models.verif as verif')
            ->where('fase','>=',2);

        }
        else if(Gate::allows('kabag')){
            $data = DB::table('pegawais')
            ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
            ->select('pegawais.*',
            'cuti_ver_models.fase as fase')
            ->where('fase','>=',3);

        }
        else if(Gate::allows('kabiro')){
            $data = DB::table('pegawais')
            ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
            ->select('pegawais.*',
            'cuti_ver_models.fase as fase')
            ->where('fase','>=',4);

        }
        if(Gate::allows('operator')){
            $data = DB::table('pegawais')
            ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
            ->select('pegawais.*',
            'cuti_ver_models.fase as fase',
            'cuti_ver_models.verif as verif',
            'cuti_ver_models.pesan as pesan',
            'cuti_ver_models.mulai as mulai',
            'cuti_ver_models.selesai as selesai')
            ->where('fase','>=',0);
            // ->whereYear('mulai',2024)
            // ->get();
            // ->whereYear('mulai',2024);
            // ->get();
        }
        else{
            $data = DB::table('pegawais')
            ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
            ->select('pegawais.*',
            'cuti_ver_models.fase as fase',
            'cuti_ver_models.verif as verif',
            'cuti_ver_models.pesan as pesan',
            'cuti_ver_models.mulai as mulai',
            'cuti_ver_models.selesai as selesai')
            ->where('fase','>=',0);
        }


        $items = $data;



        if ($request->has('month')) {
            $allowedMonths = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]; // February, May, September
            $indeksMonth = request()->month;

            if($request->month == null){
                // $data->whereRaw('(MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)',[$bulanIni, $tahunIni, $bulanIni, $tahunIni]);
                // $data->whereMonth('mulai', $bulanIni)
                // ->orWhereMonth('selesai', $bulanIni);
                $indeksMonth = "Semua Bulan";
            }else {
                // $data->whereRaw('(MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)',[$request->month, $tahunIni, $request->month, $tahunIni]);
                $items->whereMonth('mulai', $request->month)
                ->orWhereMonth('selesai', $request->month);

                $bulan = $this->months[$request->month];
                // $this->month = $request->month;
            }
        }else{
            // $data->whereRaw('(MONTH(tmt_gaji_N) = ? AND YEAR(tmt_gaji_N) = ?) OR (MONTH(tmt_gaji) = ? AND YEAR(tmt_gaji) = ?)',[$bulanIni, $tahunIni, $bulanIni, $tahunIni]);
            $items->whereMonth('mulai', $bulanIni);
            $bulan = $this->months[Carbon::now()->month];
            $indeksMonth = Carbon::now()->month;
        }



        // else{
        //     $data = DB::table('pegawais')
        //     ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
        //     ->select('pegawais.*',
        //     'cuti_ver_models.fase as fase')
        //     ->where('fase',0)
        //     ->get();
        // }

        // $data = cuti::all();

        // dd($data);

        $items= $items->get();

        return view("cuti.cuti",[
            "title"=>'Cuti',
            "data"=>$items,
            'months'=>$this->months,
            'bulan'=>$bulan,
            'indeksMonth'=>$indeksMonth
        ]);
    }


    // membuka halaman formulir surat pengantar permohonan cuti dari TU biro ke operator Adpim

    public function verif($nip){
        if (Gate::allows('kabiro')) {
            DB::table('cuti_ver_models')
            ->where('nip',$nip)
            ->update(['fase'=>0,'verif'=>1]);
        }
        else if (Gate::allows('kabag')) {
            DB::table('cuti_ver_models')
            ->where('nip',$nip)
            ->update(['fase'=>4,'verif'=>0]);

        }
        else if (Gate::allows('jft')) {
            DB::table('cuti_ver_models')
            ->where('nip',$nip)
            ->update(['fase'=>3,'verif'=>0]);

        }
        else if (Gate::allows('operator')) {
            DB::table('cuti_ver_models')
            ->where('nip',$nip)
            ->update(['fase'=>2,'verif'=>0]);

        }else{
            DB::table('cuti_ver_models')
            ->where('nip',$nip)
            ->update(['fase'=>1,'verif'=>0,'pesan'=>null]);
        }
        return redirect()->route('dashUmum');

    }


    public function operator($nip){
        $cuti = [
            1 => 'Tahunan',
            2 => 'Sakit',
            3 => 'Melahirkan',
            4 => 'Alasan Penting',
            5 => 'di Luar Tanggungan Negara',
            6 => 'Besar'
        ];
        $data = DB::table('pegawais');

        $item = $data
        ->where('nip',$nip)
        ->get();

        $dataAdmin = DB::table('pegawais')
        ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
        ->select('pegawais.*',
        'cuti_ver_models.nomorSurat as nomorSurat',
        'cuti_ver_models.jenis as jenis',
        'cuti_ver_models.hari as hari',
        'cuti_ver_models.mulai as mulai',
        'cuti_ver_models.selesai as selesai',
        'cuti_ver_models.pesan as pesan'
        )
        ->where('pegawais.nip',$nip)
        ->get();




        return view('cuti.formcuti',[
            'title'=> "Formulir Cuti",
            'nip'=>$nip,
            'dataAdmin'=> $dataAdmin,
            'item' => $item,
            'jenisCuti' => $cuti
        ]);
    }


    public function history($ket){
        history::Create([
            'NIP' => auth()->user()->NIP_User,
            'Nama'=> auth()->user()->Nama_User,
            'Keterangan'=>$ket]
        );
    }

    public function cutiVerif($nip){
        $this->history("Melakukan verifikasi cuti");
        $cuti = [
            1 => 'Tahunan',
            2 => 'Sakit',
            3 => 'Melahirkan',
            4 => 'Alasan Penting',
            5 => 'di Luar Tanggungan Negara',
            6 => 'Besar'
        ];
        $data = DB::table('pegawais');

        $item = $data
        ->where('nip',$nip)
        ->get();

        $dataAdmin = DB::table('pegawais')
        ->crossJoin("cuti_ver_models",'pegawais.nip','=','cuti_ver_models.nip')
        ->select('pegawais.*',
        'cuti_ver_models.nomorSurat as nomorSurat',
        'cuti_ver_models.jenis as jenis',
        'cuti_ver_models.hari as hari',
        'cuti_ver_models.mulai as mulai',
        'cuti_ver_models.selesai as selesai',
        'cuti_ver_models.pesan as pesan'
        )
        ->where('pegawais.nip',$nip)
        ->get();





        return view('cuti.cutiVerif',[
            'title'=> "Formulir Cuti",
            'nip'=>$nip,
            'dataAdmin'=> $dataAdmin,
            'item' => $item,
            'jenisCuti' => $cuti
        ]);
    }


    public function biro_cuti_proses_adpim(Request $req){
        $this->history("Melakukan verifikasi permohonan Cuti");
        $valid = $req->validate([
            'nip'=>'required',
            'jenis'=>'required',
            'hari'=>'required',
            'mulai'=>'required',
            'akhir'=>'required',
            'nomorSurat'=>'required'
        ]);

        // dd($valid);

        $isi =[
            'nip'=>$valid['nip'],
            'fase'=>2,
            'jenis'=>$valid['jenis'],
            'hari'=>$valid['hari'],
            'mulai'=>$valid['mulai'],
            'selesai'=>$valid['akhir'],
            'nomorSurat'=>$valid['nomorSurat']
        ];

        $cek = cuti_ver_model::where("nip",'=',$valid['nip'])->count();

        if ($cek > 0) {
            $this->verif($valid['nip']);
            return redirect()->route('dashUmum');
            // return back();
        } else {
            cuti_ver_model::create($isi);
            pegawai::where('nip','=',$valid['nip'])->update(['cuti'=>1]);

            return redirect()->route('dashUmum');
            // return back();
        }
    }

    public function biro_cuti_proses(Request $req){
        $valid = $req->validate([
            'nip'=>'required',
            'jenis'=>'required',
            'hari'=>'required',
            'mulai'=>'required',
            'akhir'=>'required',
            'nomorSurat'=>'required'
        ]);

        // dd($valid);

        $isi =[
            'nip'=>$valid['nip'],
            'fase'=>1,
            'jenis'=>$valid['jenis'],
            'hari'=>$valid['hari'],
            'mulai'=>$valid['mulai'],
            'selesai'=>$valid['akhir'],
            'nomorSurat'=>$valid['nomorSurat']
        ];

        $cek = cuti_ver_model::where("nip",'=',$valid['nip'])->count();

        if ($cek > 0) {
            $this->verif($valid['nip']);
            return redirect()->route('dashUmum');
            // return back();
        } else {
            cuti_ver_model::create($isi);
            pegawai::where('nip','=',$valid['nip'])->update(['cuti'=>1]);

            return redirect()->route('dashUmum');
            // return back();
        }
    }

    public function tolak(Request $request, $nip){
        $this->history("Menolak Permohonan Cuti");
        DB::table('cuti_ver_models')
        ->where('nip',$nip)
        ->update([
                'pesan'=> $request->pesan,
                'verif' => '-1',
                'fase'=> '0']
        );

                return redirect()->route('kgb.view');
    }

}
