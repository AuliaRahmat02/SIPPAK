<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bezController;
use App\Http\Controllers\dukController;
use App\Http\Controllers\KgbController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\tampilController;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\PensiunController;
use App\Http\Controllers\UsersetController;
use App\Http\Controllers\HistorisController;
use App\Http\Controllers\rekapKGBController;
use App\Http\Controllers\SuratKGBController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratCutiController;
use App\Http\Controllers\IstriSuamiController;
use App\Http\Controllers\PrintSuratController;
use App\Http\Controllers\IjazahGelarController;
use App\Http\Controllers\NaikPangkatController;
use App\Http\Controllers\SatyalencanaController;
use App\Http\Controllers\KenaikanPangkatController;

// use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/Login', [LoginController::class, 'login'])->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');

// untuk board

Route::get('/dashboard/admin', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/operator', [DashboardController::class, 'operator'])->middleware('auth');
Route::get('/dashboard/opadpim', [DashboardController::class, 'adpim'])->middleware('auth');
Route::get('/dashboard/adpim', [DashboardController::class, 'adpim'])->middleware('auth');
Route::get('/dashboard/organisasi', [DashboardController::class, 'organisasi'])->middleware('auth');
Route::get('/dashboard/pemerintahan', [DashboardController::class, 'pemotonom'])->middleware('auth');
Route::get('/dashboard/perekonomian', [DashboardController::class, 'perekonomian'])->middleware('auth');
Route::get('/dashboard/hukum', [DashboardController::class, 'hukum'])->middleware('auth');
Route::get('/dashboard/sekda', [DashboardController::class, 'sekda'])->middleware('auth');
Route::get('/dashboard/kesra', [DashboardController::class, 'kesra'])->middleware('auth');
Route::get('/dashboard/adpem', [DashboardController::class, 'adpem'])->middleware('auth');
Route::get('/dashboard', [LoginController::class, 'dashboard'])->middleware('auth')->name('dashUmum');
Route::get('/dashboard/pbj', [DashboardController::class, 'barangjasa'])->middleware('auth');
Route::get('/dashboard/umum', [DashboardController::class, 'umum'])->middleware('auth');
Route::get('/dashboard/datapegawai/{nip}', [DashboardController::class, 'ProfilPegawai'])->middleware('auth')->name('na');
Route::post('/uploadBahan', [DashboardController::class, 'uploadBahan'])->middleware('auth');
Route::get('/bahan/{id}', [DashboardController::class, 'viewPdf']);


// untuk dashboard
Route::get('/buku', [BookController::class, 'fetchAndStore'])->middleware('admin');
Route::get('/pip', [BookController::class, 'usia']);




// menampilkan halaman setting user
Route::get('/userset', [UsersetController::class, 'showuser'])->middleware('admin');

// menampilkan halaman registrasi
Route::get('/Registrasi', [UsersetController::class, 'Registrasi'])->middleware('guest');


// ===============================================BAGIAN REGISTRASI OPERATOR==================================
// menampilkan halaman registrasi
Route::get('/RegistrasiOPR', [UsersetController::class, 'RegistrasiOPR'])->middleware('guest');

// melakukan proses pada registrasi user OPR baru
Route::post('/registOPR', [UsersetController::class, 'Registrasi_ProsesOPR'])->middleware('guest');



// ===============================================BAGIAN REGISTRASI OPERATOR==================================
// menampilkan halaman registrasi
Route::get('/RegistrasiOPR', [UsersetController::class, 'RegistrasiOPR'])->middleware('guest');

// melakukan proses pada registrasi user JFT baru
Route::post('/registOPR', [UsersetController::class, 'Registrasi_ProsesOPR'])->middleware('guest');


// ===============================================BAGIAN REGISTRASI JFT==================================
// menampilkan halaman registrasi
Route::get('/RegistrasiJFT', [UsersetController::class, 'RegistrasiJFT'])->middleware('guest');

// melakukan proses pada registrasi user JFT baru
Route::post('/registJFT', [UsersetController::class, 'Registrasi_ProsesJFT'])->middleware('guest');


// ===============================================BAGIAN REGISTRASI KABAG==================================
// menampilkan halaman registrasi
Route::get('/RegistrasiKBG', [UsersetController::class, 'RegistrasiKBG'])->middleware('guest');
// melakukan proses pada registrasi user KABAG
Route::post('/registKBG', [UsersetController::class, 'Registrasi_ProsesKBG'])->middleware('guest');

// ===============================================BAGIAN REGISTRASI KABIRO==================================
// menampilkan halaman registrasi
Route::get('/RegistrasiKBR', [UsersetController::class, 'RegistrasiKBR'])->middleware('guest');
// melakukan proses pada registrasi user KABIRO
Route::post('/registKBR', [UsersetController::class, 'Registrasi_ProsesKBR'])->middleware('guest');



// menampilkan halaman lupa passsword
Route::get('/lupapassword', [UsersetController::class, 'showlupa'])->middleware('guest');

// proses nip yang dikirim untuk mengirim token ke email yang seharusnya
Route::post('/verify', [UsersetController::class, 'verification'])->middleware('guest');
Route::post('/verified',[UsersetController::class,'verifiedOtp'])->name('verifiedOtp');
Route::POST('/resend-otp',[UsersetController::class,'resendOtp'])->name('resendOtp');


// menampilkan halaman ganti password
Route::get('/ubah_pass',[usersetController::class,'ubah_pass_show'])->name('ubah');
// melakukan proses ganti password
Route::post('/ubah',[usersetController::class,'ubah_pass_proses'])->name('ubah');



// set key registrasi
Route::post('/userset/regkey', [UsersetController::class, 'addKeyReg'])->middleware('admin');

// unset key registrasi
Route::get('/userset/delregkey', [UsersetController::class, 'delKeyReg'])->middleware('admin');



// =======================================KHUSUS OPR=================================
// set key registrasi
Route::post('/userset/regkeyOPR', [UsersetController::class, 'addKeyRegOPR'])->middleware('admin');

// unset key registrasi
Route::get('/userset/delregkeyOPR', [UsersetController::class, 'delKeyRegOPR'])->middleware('admin');


// =======================================KHUSUS JFT=================================
// set key registrasi
Route::post('/userset/regkeyJFT', [UsersetController::class, 'addKeyRegJFT'])->middleware('admin');

// unset key registrasi
Route::get('/userset/delregkeyJFT', [UsersetController::class, 'delKeyRegJFT'])->middleware('admin');



// =======================================KHUSUS KABAG=================================
// set key registrasi
Route::post('/userset/regkeyKBG', [UsersetController::class, 'addKeyRegKBG'])->middleware('admin');

// unset key registrasi
Route::get('/userset/delregkeyKBG', [UsersetController::class, 'delKeyRegKBG'])->middleware('admin');




// =======================================KHUSUS KABIRO=================================
// set key registrasi
Route::post('/userset/regkeyKBR', [UsersetController::class, 'addKeyRegKBR'])->middleware('admin');

// unset key registrasi
Route::get('/userset/delregkeyKBR', [UsersetController::class, 'delKeyRegKBR'])->middleware('admin');


// ====================================================KHUSUS BAGIAN LUPA PASSWORD====================================
// set key lupa password
Route::post('/userset/forgkey', [UsersetController::class, 'addKeyFor'])->middleware('admin');

// unset key lupa password
Route::get('/userset/delforgkey', [UsersetController::class, 'delKeyFor'])->middleware('admin');

// melakukan proses pada registrasi user baru
Route::post('/regist', [UsersetController::class, 'Registrasi_Proses'])->middleware('guest');


// ==============================================KHUSUS JFT====================================================




// menghapus user
Route::get('/users/{id}', [UsersetController::class, 'destroy'])->middleware('admin');

Route::get('/duk', [dukController::class, 'index'])->middleware('auth');
Route::get('/duk/export', [dukController::class, 'ex_duk'])->middleware('auth');


Route::get('/bezzetting', [bezController::class, 'showbz'])->middleware('auth');
Route::get('/bezzetting/export', [bezController::class, 'ex_bz'])->middleware('auth');
// menampilkan halaman

Route::get('/kgb', [KgbController::class,'show'])->middleware('auth')->name('kgb.view');
// kgb bulan sekarang
Route::get('/kgbDash0', [KgbController::class,'showDash1'])->middleware('auth')->name('kgb.viewDash');
// kgb bulan depan
Route::get('/kgbDash1', [KgbController::class,'showDash2'])->middleware('auth')->name('kgb.viewDash');
Route::get('/kgbDash2', [KgbController::class,'showDash3'])->middleware('auth')->name('kgb.viewDash');
// print excel kgb
Route::get('/kgb/export', [KgbController::class, 'export_kgb'])->middleware('auth');
Route::get('/rekapKGBExport',[rekapKGBController::class, 'export_kgb'])->middleware('auth');
//memprint surat naik gaji
Route::get('/printSuratKGB/{$id}',[KgbController::class, 'print_surat']);


// ============================================== BAGIAN PENGANTAR NAIK PANGKAT ====================================================
// menampilkan halaman kenaikkan pangkat
Route::get('/naikpangkat', [NaikPangkatController::class,'show'])->middleware('auth')->name('naik.view');
Route::post('/naikpangkat/buat_surat', [NaikPangkatController::class,'BuatSuratProses'])->middleware('auth');

// mengajukan dari biro ke operator
Route::post('/birosend', [NaikPangkatController::class,'biro'])->middleware('auth');

// hapus dari biro ke operator
Route::get('/Hapussend/{nip}', [NaikPangkatController::class,'Hapus_Pemohon'])->middleware('auth');

// membuat surat pengantar kenaikan pangkat
Route::post('/P_naik_op', [NaikPangkatController::class,'P_naik_op'])->middleware('auth');

// melihat preview surat
Route::get('/preview_surat/{nomor}', [PrintSuratController::class,'SpNaikPangkat'])->middleware('auth');

// membuat keputusan
Route::get('/verifikasi_naik/{nomor}', [KenaikanPangkatController::class,'verifikasi_naik'])->middleware('auth');

// menampilkan halaman tolak surat
Route::get('/tolak_show/{id}', [KenaikanPangkatController::class,'tolak_show'])->middleware('auth');

// membuat pesan penolakan keputusan
Route::post('/tolak_surat', [KenaikanPangkatController::class,'tolak_surat'])->middleware('auth');

// membuat pesan penolakan keputusan
Route::get('/perbaiki_show/{id}', [KenaikanPangkatController::class,'perbaiki_show'])->middleware('auth');

// membuat pesan penolakan keputusan
Route::post('/perbaiki', [KenaikanPangkatController::class,'perbaiki'])->middleware('auth');

// menghapus surat permohonan
Route::get('/hapus_surat/{id}', [KenaikanPangkatController::class,'hapus'])->middleware('auth');

// melihat surat pengantar
Route::get('/SuratNaik', [KenaikanPangkatController::class,'SuratRekap'])->middleware('auth');

// Menampilkan rekapitulasi Kenaikan Pangkat
Route::get('/RekapNaikPangkat', [KenaikanPangkatController::class,'Naik_Rekapitulasi'])->middleware('auth');

// melakukan export excel kenaikan pangkat
Route::get('/NaikExport/export', [KenaikanPangkatController::class, 'ExKenakikanPangkat'])->middleware('auth');



// menampilkan halaman pembuatan surat cuti
Route::get('/cuti', function () {
    return view('formcuti', [
        "title" => "Cuti"
    ]);
})->middleware('auth');




//print surat cuti
Route::get('/print',[PrintSuratController::class,'print'])->name('print');

// Route::get('/printSuratKGB/{id}',[SuratKGBController::class,'cetak']);

Route::get('/ajukanKGB/{id}',[KgbController::class,'ajukanKGB']);

Route::get('/verifKGB/{id}',[KgbController::class,'verifKGB']);

Route::get('/verifKGB/kabiro/{id}', [KgbController::class,'verifKabiro' ]);

// Route::get('/removeKGB/{id}',[KgbController::class,'removeKGB']);



Route::get('/formkgb/{id}',[KgbController::class,'formAjukan']);



Route::get('/uploadKGB',[KgbController::class,'uploadKGB'])->name('uploadKGB');

//memprint surat naik gaji
Route::get('/printKGB/{id}',[SuratKGBController::class, 'cetak'])->name('printKGB');


//Rekapitulasi
Route::get('/rekapKGB',[rekapKGBController::class,'show'])->name('rekapKGB');






Route::get('/ajukanKGB/{id}',[KgbController::class,'ajukanKGB']);

Route::get('/verifKGB/{id}',[KgbController::class,'verifKGB']);

Route::get('/verifKGB/kabiro/{id}', [KgbController::class,'verifKabiro' ]);

Route::get('/removeKGB/{id}',[KgbController::class,'removeKGB']);




//print surat cuti
Route::get('/print',[PrintSuratController::class,'print'])->name('print');

Route::get('/printSuratKGB/{id}',[SuratKGBController::class,'cetak']);



// ======================================BAGIAN CUTI======================================================
// menampilkan halaman pembuatan surat cuti
Route::get('/cuti', [CutiController::class,'show'])->middleware('auth')->name('cuti.view');
Route::get('/cuti/formcuti/{nip}', [CutiController::class,'operator'])->middleware('auth');
Route::get('/cuti/cutiVerif/{nip}', [CutiController::class,'cutiVerif'])->middleware('auth');
Route::post('/cuti/formcuti_proses', [CutiController::class,'biro_cuti_proses'])->middleware('auth')->name('proses_cuti');
Route::post('/cuti/formcuti_proses_adpim', [CutiController::class,'biro_cuti_proses_adpim'])->middleware('auth')->name('proses_cuti_adpim');

Route::get('/cuti/verif/{nip}', [CutiController::class,'verif'])->middleware('auth')->name('verif_cuti');
Route::get('/cuti/export', [CutiController::class, 'export_cuti'])->middleware('auth');


Route::get('/rekapCuti', [CutiController::class,'rekapCuti'])->middleware('auth');


// ============================================== Surat pengantar ===============================================
Route::get('/pengantar', [DashboardController::class,'showPengantar'])->middleware('auth');

// menampilkan kenaikan untuk adpim, jft, biro, kabiro
Route::get('/kenaikanpangkat', [KenaikanPangkatController::class,'KenaikanPangkat'])->middleware('auth');

// menampilkan surat belajar untuk adpim, jft, biro, kabiro
Route::get('/belajar', [BelajarController::class,'showBelajar'])->middleware('auth');

// menampilkan ijazah untuk adpim, jft, biro, kabiro
Route::get('/ijazah', [IjazahGelarController::class,'showIjazah'])->middleware('auth');

// menampilkan kartu suami istri untuk adpim, jft, biro, kabiro
Route::get('/kartu', [IstriSuamiController::class,'showKartu'])->middleware('auth');

// menampilkan pengantar surat pensiun untuk adpim, jft, biro, kabiro
Route::get('/pensiun', [PensiunController::class,'showPensiun'])->middleware('auth');

// menampilkan pengantar surat  untuk adpim, jft, biro, kabiro
Route::get('/satyalencana', [SatyalencanaController::class,'showSatya'])->middleware('auth');

// kembali dari formulir penolakan atau edit surat
Route::get('/back/{id}', [IstriSuamiController::class,'kembali'])->middleware('auth');

// Download Surat Pengantar
Route::get('/DownloadSurat/{ID_surat}',[PrintSuratController::class,"LoadSuratPengantar"]);




//  ===============================================BABGIAN KABIRO==========================================================

Route::get('/kabiro', [UsersetController::class,'showKabiro'])->middleware('Kabiro');
Route::post('/kabiro_proses', [UsersetController::class,'UpdateDataKabiro'])->name('kabiro_proses')->middleware('auth');

Route::get('/printCuti/{id}',[SuratCutiController::class, 'cetak'])->name('printCuti');
Route::get('/tolakCuti/{id}',[CutiController::class,'tolak']);




// =============================================BAGIAN PENGANTAR PENSIUN===============================================================
// proses pengajuan surat pengantar pensiun dari biro
Route::get('/Ajukan_Pensiun/{nip}', [PensiunController::class,'AjukanPensiun'])->middleware('Operator');

// hapus dari biro ke operator
Route::get('/HapusPensiun/{nip}', [PensiunController::class,'Hapus_Pemohon'])->middleware('Operator');

// membuat surat pengantar kenaikan pangkat
Route::post('/P_Pensiun_op', [PensiunController::class,'P_Pensiun_op'])->middleware('auth');

// hapus dari biro ke operator
Route::get('/del_pensiun/{nip}', [PensiunController::class,'hapus_surat'])->middleware('auth');

// verifikasi surat kartu
Route::get('/verifikasi_pensiun/{id}', [PensiunController::class,'verifikasi_pensiun'])->middleware('auth');

// Route::post('/kabiro_proses', [PensiunController::class,'UpdateDataKabiro'])->name('kabiro_proses')->middleware('Operator');

// Route::get('/printCuti/{id}',[PensiunController::class, 'cetak'])->name('printCuti');

Route::get('/SuratPensiun', [PensiunController::class,'SuratRekap'])->middleware('auth');

// Menampilkan rekapitulasi Pensiun
Route::get('/RekapPensiun', [PensiunController::class,'Pensiun_Rekapitulasi'])->middleware('auth');

// melakukan export excel kenaikan pangkat
Route::get('/PensiunExport/export', [PensiunController::class, 'ExPensiun'])->middleware('auth');




// =============================================BAGIAN PENGANTAR IJAZAH===============================================================
// proses pengajuan surat pengantar Ijazah dari biro
Route::get('/Ajukan_Ijazah/{nip}', [IjazahGelarController::class,'AjukanIjazah'])->middleware('Operator');

// hapus dari biro ke operator
Route::get('/HapusIjazah/{nip}', [IjazahGelarController::class,'Hapus_Pemohon'])->middleware('auth');

// membuat surat pengantar kenaikan pangkat
Route::post('/P_Ijazah_op', [IjazahGelarController::class,'P_Ijazah_op'])->middleware('auth');

// hapus dari biro ke operator
Route::get('/del_ijazah/{nip}', [IjazahGelarController::class,'hapus_surat'])->middleware('auth');

// verifikasi surat kartu
Route::get('/verifikasi_ijazah/{id}', [IjazahGelarController::class,'verifikasi_ijazah'])->middleware('auth');

// Route::post('/kabiro_proses', [PensiunController::class,'UpdateDataKabiro'])->name('kabiro_proses')->middleware('Operator');

// Route::get('/printCuti/{id}',[PensiunController::class, 'cetak'])->name('printCuti');
Route::get('/SuratIjazah', [IjazahGelarController::class,'SuratRekap'])->middleware('auth');


// =============================================BAGIAN PENGANTAR SATYALENCANA===============================================================
// proses pengajuan surat pengantar satyalencana dari biro
Route::get('/Ajukan_Sat/{nip}', [SatyalencanaController::class,'AjukanSat'])->middleware('Operator');

// hapus dari biro ke operator
Route::get('/HapusSat/{nip}', [SatyalencanaController::class,'Hapus_Pemohon'])->middleware('auth');

// membuat surat pengantar kenaikan pangkat
Route::post('/P_Sat_op', [SatyalencanaController::class,'P_Sat_op'])->middleware('auth');

// hapus dari biro ke operator
Route::get('/del_sat/{nip}', [SatyalencanaController::class,'hapus_surat'])->middleware('auth');

// verifikasi surat kartu
Route::get('/verifikasi_sat/{id}', [SatyalencanaController::class,'verifikasi_sat'])->middleware('auth');

// Route::post('/kabiro_proses', [PensiunController::class,'UpdateDataKabiro'])->name('kabiro_proses')->middleware('Operator');

// Route::get('/printCuti/{id}',[PensiunController::class, 'cetak'])->name('printCuti');

Route::get('/SuratSat', [SatyalencanaController::class,'SuratRekap'])->middleware('auth');



// =============================================BAGIAN PENGANTAR BELAJAR===============================================================
// proses pengajuan surat pengantar satyalencana dari biro
Route::get('/Ajukan_Belajar/{nip}', [BelajarController::class,'AjukanBelajar'])->middleware('Operator');

// hapus dari biro ke operator
Route::get('/HapusBelajar/{nip}', [BelajarController::class,'Hapus_Pemohon'])->middleware('Operator');

// membuat surat pengantar kenaikan pangkat
Route::post('/P_Belajar_op', [BelajarController::class,'P_Belajar_op'])->middleware('auth');

// hapus dari biro ke operator
Route::get('/del_belajar/{nip}', [BelajarController::class,'hapus_surat'])->middleware('auth');

// verifikasi surat kartu
Route::get('/verifikasi_belajar/{id}', [BelajarController::class,'verifikasi_belajar'])->middleware('auth');

// Route::post('/kabiro_proses', [PensiunController::class,'UpdateDataKabiro'])->name('kabiro_proses')->middleware('Operator');

// Route::get('/printCuti/{id}',[PensiunController::class, 'cetak'])->name('printCuti');
Route::get('/SuratBelajar', [BelajarController::class,'SuratRekap'])->middleware('auth');




// =============================================BAGIAN PENGANTAR KARTU SUAMI ISTERI===============================================================
// proses pengajuan surat pengantar kartu suami isteri dari biro
Route::get('/Ajukan_Kartu/{nip}', [IstriSuamiController::class,'AjukanKartu'])->middleware('Operator');

// hapus dari biro ke operator
Route::get('/HapusKartu/{nip}', [IstriSuamiController::class,'Hapus_Pemohon'])->middleware('auth');

// hapus dari biro ke operator
Route::get('/del_kartu/{nip}', [IstriSuamiController::class,'hapus_surat'])->middleware('auth');

// Route::post('/kabiro_proses', [PensiunController::class,'UpdateDataKabiro'])->name('kabiro_proses')->middleware('Operator');

// Route::get('/printCuti/{id}',[PensiunController::class, 'cetak'])->name('printCuti');

// membuat surat pengantar kenaikan pangkat
Route::post('/P_kartu_op', [IstriSuamiController::class,'P_kartu_op'])->middleware('auth');

// verifikasi surat kartu
Route::get('/verifikasi_kartu/{id}', [IstriSuamiController::class,'verifikasi_kartu'])->middleware('auth');
Route::get('/SuratKartu', [IstriSuamiController::class,'SuratRekap'])->middleware('auth');



Route::post('/cutiUpload', [FileController::class, 'store'])->name('uploadcuti');
// Route::post('/updateCuti', [FileController::class, 'store'])->name('uploadcuti');

Route::get('/files/download/{id}', [tampilController::class, 'viewPdf'])->name('files.download');
Route::get('/files/show/{id}', [tampilController::class, 'showPdfView'])->name('files.show');
Route::get('/files/check/{id}', [tampilController::class, 'checkPdf'])->name('files.check');


Route::get('/history', [HistorisController::class, 'show']);
