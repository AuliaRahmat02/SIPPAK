<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

// use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
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
        // dd($reg);
        return view('userset.login',[
            'title'=>'Login',
            'reg'=>$reg,
            'regOPR'=>$regOPR,
            'regJFT'=>$regJFT,
            'regKBG'=>$regKBG,
            'regKBR'=>$regKBR,
            'forgot'=>$forgot,
        ]);
    }

    // Proses login
    public function login(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ],[
            'username'=>[
                'required'=>'Login anda gagal!',
                'max'=>"Login anda gagal!"
            ],
            'password'=>[
                'required'=>'Login anda gagal!',
                'min'=>"Login anda gagal!"
            ]
        ]);

        $input['NIP_User']= $valid['username'];
        $input['password']= $valid['password'];

        if(Auth::attempt($input)){
            $request->session()->regenerate();

            return $this->dashboard();
        }

        return back()->with('loginError','Login anda gagal');
    }


    public function dashboard(){

        if (Gate::any(['admin','jft','kabag','kabiro'])) {
            return redirect()->intended('/dashboard/admin');
        }


        if (Gate::allows('operator')) {
            return redirect()->intended('/dashboard/operator');
        }


        if (Gate::allows('opAdpim')) {
            return redirect()->intended('/dashboard/opadpim');
        }


        if (Gate::allows('opAdpem')) {
            return redirect()->intended('/dashboard/adpem');
        }

        if (Gate::allows('opKesra')) {
            return redirect()->intended('/dashboard/kesra');
        }


        if (Gate::allows('opPerekonomian')) {
            return redirect()->intended('/dashboard/perekonomian');
        }

        if (Gate::allows('opHukum')) {
            return redirect()->intended('/dashboard/hukum');
        }

        if (Gate::allows('opPBJ')) {
            return redirect()->intended('/dashboard/pbj');
        }

        if (Gate::allows('opPemerintahan')) {
            return redirect()->intended('/dashboard/pemerintahan');
        }


        if (Gate::allows('opUmum')) {
            return redirect()->intended('/dashboard/umum');
        }


        if (Gate::allows('opOrganisasi')) {
            return redirect()->intended('/dashboard/organisasi');
        }   
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


}
