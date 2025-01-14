<?php

namespace App\Http\Controllers;

use App\Models\users;
use App\Models\Tokens;
use App\Models\kontrolModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
// use Mail;

class UsersetController extends Controller
{
    // menampilkan halamn usersetting -> (ADMIN)
    public function showuser(){

        $reg = DB::table('kontrol')
                        ->where('set','=',"REG")
                        ->where('code','=','539')
                        ->count();

        $regOPR = DB::table('kontrol')
                        ->where('set','=',"OPR")
                        ->where('code','=','555')
                        ->count();


        $regJFT = DB::table('kontrol')
                        ->where('set','=',"JFT")
                        ->where('code','=','531')
                        ->count();

        $regKBG = DB::table('kontrol')
                        ->where('set','=',"KBG")
                        ->where('code','=','532')
                        ->count();

        $regKBR = DB::table('kontrol')
                        ->where('set','=',"KBR")
                        ->where('code','=','533')
                        ->count();

        $forgot = DB::table('kontrol')
                        ->where('set','=',"FRG")
                        ->where('code','=','935')
                        ->count();

        return view('userset.userset',[
            'title'=>'User Setting',
            'admin'=>users::where('biro','<','10')->get(),
            'reg'=>$reg,
            'regOPR'=>$regOPR,
            'regJFT'=>$regJFT,
            'regKBG'=>$regKBG,
            'regKBR'=>$regKBR,
            'forgot'=>$forgot,
        ]);
    }



    // menampilkan halaman registrasi TU Biro
    public function Registrasi()
    {
        return view("userset.register",[
            "title" => "Registrasi"
        ]);

    }

    // melakukan proses registrasi TU Biro
    public function Registrasi_Proses(Request $req)
    {

        $valid = $req->validate([
            "nip"=>"required|min:18|max:18",
            "nama"=>"required|min:5|max:30",
            "biro"=>"required",
            "email"=>"required|string|email|max:255|unique:users",
            "pass"=> 'required|min:8',
        ],[
            'nip'=>[
                'required'=>'NIP wajib diisi',
                'min'=>'jumlah NIP kurang dari 18 karakter',
                'max'=>'jumlah NIP melebihi 18 karakter',
            ],
            'nama'=>[
                'required'=>'Nama wajib diisi',
                'min'=>'jumlah Nama kurang dari 5 karakter',
                'max'=>'jumlah Nama melebihi 30 karakter',
            ],
            'biro'=>[
                'required'=>'Nama wajib diisi',
            ],
            'email'=>[
                'required'=>'email wajib diisi',
            ],
            'pass'=>[
                'required'=>'Password wajib diisi',
                'min'=>'jumlah Password kurang dari 8 karakter',
            ]
        ]);



        $valid['pass'] = Hash::make($valid['pass']);
        $valid['biro'] = (int)$valid['biro'];
        $input = [
            "NIP_User" => $valid['nip'],
            "Nama_User" => $valid['nama'],
            "Password" => $valid['pass'],
            "email" => $valid['email'], // Pastikan ini terisi dengan benar
            "biro" => $valid['biro'],
        ];
        users::create($input);
        // dd($input);
        return redirect("/");
    }



    // ================================================================KHUSUS OPR==================================
    // menampilkan halaman registrasi OPR
    public function RegistrasiOPR()
    {
        return view("userset.registerOPR",[
            "title" => "Registrasi"
        ]);

    }

    // melakukan proses registrasi OPR
    public function Registrasi_ProsesOPR(Request $req)
    {

        $valid = $req->validate([
            "nip"=>"required|min:18|max:18",
            "nama"=>"required|min:5|max:30",
            "email"=>"required|string|email|max:255|unique:users",
            "pass"=> 'required|min:8',
        ],[
            'nip'=>[
                'required'=>'NIP wajib diisi',
                'min'=>'jumlah NIP kurang dari 18 karakter',
                'max'=>'jumlah NIP melebihi 18 karakter',
            ],
            'nama'=>[
                'required'=>'Nama wajib diisi',
                'min'=>'jumlah Nama kurang dari 5 karakter',
                'max'=>'jumlah Nama melebihi 30 karakter',
            ],
            'email'=>[
                'required'=>'email wajib diisi',
            ],
            'pass'=>[
                'required'=>'Password wajib diisi',
                'min'=>'jumlah Password kurang dari 8 karakter',
            ]
        ]);



        $valid['pass'] = Hash::make($valid['pass']);
        $input = [
            "NIP_User" => $valid['nip'],
            "Nama_User" => $valid['nama'],
            "Password" => $valid['pass'],
            "email" => $valid['email'], // Pastikan ini terisi dengan benar
            "biro" => 3,
            "opadpim" => true,
        ];
        users::create($input);
        // dd($input);
        return redirect("/");
    }




    // ================================================================KHUSUS JFT==================================
    // menampilkan halaman registrasi JFT
    public function RegistrasiJFT()
    {
        return view("userset.registerJFT",[
            "title" => "Registrasi"
        ]);

    }

    // melakukan proses registrasi JFT
    public function Registrasi_ProsesJFT(Request $req)
    {

        $valid = $req->validate([
            "nip"=>"required|min:18|max:18",
            "nama"=>"required|min:5|max:30",
            "email"=>"required|string|email|max:255|unique:users",
            "pass"=> 'required|min:8',
        ],[
            'nip'=>[
                'required'=>'NIP wajib diisi',
                'min'=>'jumlah NIP kurang dari 18 karakter',
                'max'=>'jumlah NIP melebihi 18 karakter',
            ],
            'nama'=>[
                'required'=>'Nama wajib diisi',
                'min'=>'jumlah Nama kurang dari 5 karakter',
                'max'=>'jumlah Nama melebihi 30 karakter',
            ],
            'email'=>[
                'required'=>'email wajib diisi',
            ],
            'pass'=>[
                'required'=>'Password wajib diisi',
                'min'=>'jumlah Password kurang dari 8 karakter',
            ]
        ]);



        $valid['pass'] = Hash::make($valid['pass']);
        $input = [
            "NIP_User" => $valid['nip'],
            "Nama_User" => $valid['nama'],
            "Password" => $valid['pass'],
            "email" => $valid['email'], // Pastikan ini terisi dengan benar
            "biro" => 3,
            "jft" => true,
        ];
        users::create($input);
        // dd($input);
        return redirect("/");
    }



    // ================================================================KHUSUS KABAG==================================
    // menampilkan halaman registrasi KABAG
    public function RegistrasiKBG()
    {
        return view("userset.registerKBG",[
            "title" => "Registrasi Kabag"
        ]);

    }

    // melakukan proses registrasi JFT
    public function Registrasi_ProsesKBG(Request $req)
    {

        $valid = $req->validate([
            "nip"=>"required|min:18|max:18",
            "nama"=>"required|min:5|max:30",
            "email"=>"required|string|email|max:255|unique:users",
            "pass"=> 'required|min:8',
        ],[
            'nip'=>[
                'required'=>'NIP wajib diisi',
                'min'=>'jumlah NIP kurang dari 18 karakter',
                'max'=>'jumlah NIP melebihi 18 karakter',
            ],
            'nama'=>[
                'required'=>'Nama wajib diisi',
                'min'=>'jumlah Nama kurang dari 5 karakter',
                'max'=>'jumlah Nama melebihi 30 karakter',
            ],
            'email'=>[
                'required'=>'email wajib diisi',
            ],
            'pass'=>[
                'required'=>'Password wajib diisi',
                'min'=>'jumlah Password kurang dari 8 karakter',
            ]
        ]);



        $valid['pass'] = Hash::make($valid['pass']);
        $input = [
            "NIP_User" => $valid['nip'],
            "Nama_User" => $valid['nama'],
            "Password" => $valid['pass'],
            "email" => $valid['email'], // Pastikan ini terisi dengan benar
            "biro" => 3,
            "kabag" => true,
        ];
        users::create($input);
        // dd($input);
        return redirect("/");
    }




    // ================================================================KHUSUS KABIRO==================================
    // menampilkan halaman registrasi KABIRO
    public function RegistrasiKBR()
    {
        return view("userset.registerKBR",[
            "title" => "Registrasi Kabiro"
        ]);

    }

    // melakukan proses registrasi KABIRO
    public function Registrasi_ProsesKBR(Request $req)
    {

        $valid = $req->validate([
            "nip"=>"required|min:18|max:18",
            "nama"=>"required|min:5|max:30",
            "email"=>"required|string|email|max:255|unique:users",
            "pass"=> 'required|min:8',
        ],[
            'nip'=>[
                'required'=>'NIP wajib diisi',
                'min'=>'jumlah NIP kurang dari 18 karakter',
                'max'=>'jumlah NIP melebihi 18 karakter',
            ],
            'nama'=>[
                'required'=>'Nama wajib diisi',
                'min'=>'jumlah Nama kurang dari 5 karakter',
                'max'=>'jumlah Nama melebihi 30 karakter',
            ],
            'email'=>[
                'required'=>'email wajib diisi',
            ],
            'pass'=>[
                'required'=>'Password wajib diisi',
                'min'=>'jumlah Password kurang dari 8 karakter',
            ]
        ]);



        $valid['pass'] = Hash::make($valid['pass']);
        $input = [
            "NIP_User" => $valid['nip'],
            "Nama_User" => $valid['nama'],
            "Password" => $valid['pass'],
            "email" => $valid['email'], // Pastikan ini terisi dengan benar
            "biro" => 3,
            "kabiro" => true,
        ];
        users::create($input);
        // dd($input);
        return redirect("/");
    }





    //logout process
    public function destroy($nip)
    {
        $user = users::where('NIP_User','=',$nip);
        $user->delete();
        return redirect('/userset');
    }

    // //
    // public function addReg($req){
    //     $ved = $req;
    //     pegawai::create($ved);
    //     return redirect('/dashboard');
    // }



    // menampilkan halaman lupa password
    public function showlupa(){
        return view('/userset/lupapassword',[
            "title"=>"NIP input",
        ]);
    }


    // mengirim otp ke email
    public function sendOtp($user)
    {
        $otp = rand(100000,999999);
        $time = time();

        // dd($time);

        Tokens::updateOrCreate(
            ['email'=>$user->email],
            [
                'email'=>$user->email,
                'token' => $otp,
                'created' => $time
            ]
        );

        $data['email'] = $user->email;
        // dd($data['email']);
        $data['title'] = 'OTP Verifikasi';

        $data['body'] = 'Kode OTP untuk Menukar Password :- '.$otp;

        Mail::send('mail.email',['data'=>$data],function($message) use ($data){
            $message->to($data['email'])->subject($data['title']);
        });
    }


    // verifikasi email yang akan di kirirmi otp
    public function verification(Request $req)
    {
        $id = $req->validate([
            'nip'=>'required|min:18|max:18'
        ]);
        $user = users::where('NIP_User',$id)->first();

        $email = $user->email;
        $nip = $user->NIP_User;

        $this->sendOtp($user);//OTP SEND

        return view('userset.verifikasi',[
            "title"=>'Verifikasi OTP',
            'email'=>$email,
            'nip'=>$nip
        ]);
    }

    // proses verifikasi otp
    public function verifiedOtp(Request $otp)
    {
        $isi = $otp->validate([
            'nip'=>'required|min:18|max:18',
            'email'=>'required',
            'otp'=>'required|min:6|max:6',
        ]);

        // dd($isi);
        // $cekotp = Tokens::where('token',$isi['otp'])->count();
        $otpData = Tokens::where('token',$isi['otp'])->first();

        if($otpData != null){
            users::where('email',$isi['email'])->update(['is_verified'=>true]);
            $nip = (string) $isi['nip'];
            return redirect('/ubah_pass')->with('nip', $nip);

        }else{
            $user = users::where('NIP_User',$isi['nip'])->first();
            Tokens::where('email',$user->email)->delete();
            return redirect('/lupapassword');
        }
    }


    // mengirim ulang otp
    public function resendOtp(Request $request)
    {
        $user = users::where('email',$request->email)->first();
        $otpData = Tokens::where('email',$request->email)->first();

        $currentTime = time();
        $time = $otpData->created_at;

        if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
            return back()->withErrors(['err'=>'coba lagi setelah waktu habis']);
        }
        else{
            $this->sendOtp($user);//OTP SEND
            return response()->json(['success' => true,'msg'=> 'OTP has been sent']);
        }

    }

    // // menampilkan halaman ubah password
    public function ubah_pass_show(){
        $nip = session('nip');
        if($nip==null){
            return redirect('/lupapassword');
        }else{
            $verified = users::select('is_verified')->where('NIP_User',$nip);
            if ($verified == false) {
                return redirect('/lupapassword');
            } else {
                return view('userset.ubahpassword',[
                    'title'=>'Ubah Sandi',
                    'nip'=>session('nip')
                ]);
            }

        }
    }



    // tukar password proses
    public function ubah_pass_proses(Request $req){
        $isi = $req->validate([
            'nip'=>'required|min:18|max:18',
            'pass1'=>'required|min:8',
            'pass2'=>'required|min:8',
        ]);

        $kunci = users::select('is_verified')->where('NIP_User',$isi['nip'])->get();
        if (($kunci == true) OR ($kunci == 1)) {
            if($isi['pass1']===$isi['pass2']){
                $sandi = Hash::make($isi['pass1']);
                users::where('NIP_User',$isi['nip'])->update(['Password'=>$sandi]);
                users::where('NIP_User',$isi['nip'])->update(['is_verified'=>false]);
                $user = users::where('NIP_User',$isi['nip'])->first();
                Tokens::where('email',$user->email)->delete();
                return redirect('/');
            }else{
                return back()->withErrors(['error'=>'sandi yang dimasukkan keduanya tidak sama']);
            }
        } else {
            return redirect('/');
        }
    }




    // set kunci registrasi
    public function addKeyReg(Request $set){
        $key = $set->validate([
            'set'=> 'required|unique:kontrol,set',
            'core'=> 'required|unique:kontrol,code',
        ]);

        $key['core']= (int)$key['core'];


        $let['set'] = $key['set'];
        $let['code'] = $key['core'];
        kontrolModel::create($let);
        // dd($let);
        return redirect('/userset');
    }
    // delete kunci registrasi
    public function delKeyReg(){
        $key = kontrolModel::where('set','=','REG');
        $key->delete();
        return redirect('/userset');
    }


    // ================================KHUSUS OPERATOR=====================================
    // set kunci registrasi OPR
    public function addKeyRegOPR(Request $set){
        $key = $set->validate([
            'set'=> 'required|unique:kontrol,set',
            'core'=> 'required|unique:kontrol,code',
        ]);

        $key['core']= (int)$key['core'];


        $let['set'] = $key['set'];
        $let['code'] = $key['core'];
        kontrolModel::create($let);
        // dd($let);
        return redirect('/userset');
    }
    // delete kunci registrasi JFT
    public function delKeyRegOPR(){
        $key = kontrolModel::where('set','=','OPR');
        $key->delete();
        return redirect('/userset');
    }


    // ================================KHUSUS JFT=====================================
    // set kunci registrasi JFT
    public function addKeyRegJFT(Request $set){
        $key = $set->validate([
            'set'=> 'required|unique:kontrol,set',
            'core'=> 'required|unique:kontrol,code',
        ]);

        $key['core']= (int)$key['core'];


        $let['set'] = $key['set'];
        $let['code'] = $key['core'];
        kontrolModel::create($let);
        // dd($let);
        return redirect('/userset');
    }
    // delete kunci registrasi JFT
    public function delKeyRegJFT(){
        $key = kontrolModel::where('set','=','JFT');
        $key->delete();
        return redirect('/userset');
    }


    // ================================KHUSUS KABAG=====================================
    // set kunci registrasi JFT
    public function addKeyRegKBG(Request $set){
        $key = $set->validate([
            'set'=> 'required|unique:kontrol,set',
            'kbg'=> 'required|unique:kontrol,code',
        ]);

        $key['kbg']= (int)$key['kbg'];


        $let['set'] = $key['set'];
        $let['code'] = $key['kbg'];
        kontrolModel::create($let);
        // dd($let);
        return redirect('/userset');
    }
    // delete kunci registrasi JFT
    public function delKeyRegKBG(){
        $key = kontrolModel::where('set','=','KBG');
        $key->delete();
        return redirect('/userset');
    }


    // ================================KHUSUS KABIRO=====================================
    // set kunci registrasi KABIRO
    public function addKeyRegKBR(Request $set){
        $key = $set->validate([
            'set'=> 'required|unique:kontrol,set',
            'kbr'=> 'required|unique:kontrol,code',
        ]);

        $key['core']= (int)$key['kbr'];


        $let['set'] = $key['set'];
        $let['code'] = $key['kbr'];
        kontrolModel::create($let);
        // dd($let);
        return redirect('/userset');
    }
    // delete kunci registrasi KABIRO
    public function delKeyRegKBR(){
        $key = kontrolModel::where('set','=','KBR');
        $key->delete();
        return redirect('/userset');
    }



    // =========================================================KHUSUS BAGIAN LUPA PASSWORD
    // set kunci forget password
    public function addKeyFor(Request $reg){
        $key = $reg->validate([
            'set'=> 'required',
            'codes'=> 'required',
        ]);

        $key['codes']= (int)$key['codes'];

        $set['set'] = $key['set'];
        $set['code'] = $key['codes'];
        kontrolModel::create($set);

        // dd($set);
        return redirect('/userset');
    }

    // delete forget password
    public function delKeyFor(){
        $key = kontrolModel::where('set','=','FRG');
        $key->delete();
        return redirect('/userset');
    }



    // ==================================================BAGIAN KABIRO=================================================================
    // ==================================================BAGIAN KABIRO=================================================================
    // ==================================================BAGIAN KABIRO=================================================================
    // ==================================================BAGIAN KABIRO=================================================================


    public function showKabiro(){
        $user = users::where('kabiro',"=",1)->first();

        // dd($user);
        return response()->view('userset.kabiro',[
            'title'=>'Data Kabiro',
            'nip'=>$user['NIP_User'],
            'nama'=>$user['Nama_User'],
            'email'=>$user['email'],
            'biro'=>$user['biro'],
            'tipedata'=>$user['tipedata'],
            'ttd'=>$user['ttd'],
        ]);
    }

    public function UpdateDataKabiro(Request $up){
        $valid = $up->validate([
            'nip'=>'required|max:18|min:18',
            'nama'=>'required',
            'gmail'=>'required',
            'ttd'=>'required|image',
        ]);
        // dd($valid['ttd']);

        $file = $valid['ttd'];
        
        $ttdfile = file_get_contents($file);
        $mime = (string) $file->getClientMimeType();

        // menyimpan gambar ke database
        Users::where('kabiro','=',1)->update([
            'NIP_User' => $valid['nip'],
            'Nama_User' => $valid["nama"],
            'email' => $valid["gmail"],
            'ttd' => $ttdfile,
            'tipedata' => $mime,
        ]);

        // // Storage::disk('public')->delete($path);

        // // Redirect dengan pesan sukses
        return redirect('/kabiro');
    }




}
