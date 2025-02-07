<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable=[
        "opd_id",
        "opd_nm",
        "sub_opd_id",
        "sub_opd_nm",
        "jns_jbtn_id",
        "jns_jbtn_nm",
        "jabatan_id",
        "jabatan_nm",
        "tmt_jabatan",



        "nip",
        "nama_pns",
        "tmpt_lahir",
        "tgl_lahir",
        "gender_id",
        "gender_nm",
        "agama_id",
        "agama_nm",
        "karpeg",
        "cpns_pns_id",
        "cpns_pns_nm",
        "status_pns_id",
        "status_pns_nm",
        "alamat",
        "kawin_id",
        "kawin_nm",
        "no_askes",
        "taspen",
        "npwp",
        "karis",


        "sk_cpns",
        "tgl_cpns",
        "tmt_cpns",
        "golru_cpns",


        "sk_pns",
        "tgl_pns",
        "tmt_pns",
        "golru_pns",
        "golru_id",
        "golru_nm",
        "pangkat",
        "tmt_golru_B",
        "tmt_golru",
        "tmt_golru_N",
        "masa_kerja",


        "tmt_gaji_B",
        "tmt_gaji",
        "tmt_gaji_N",
        "mk_gaji",
        "gapok",


        "eselon_id",
        "eselon_nm",
        "jenjang_id",
        "jenjang_nm",
        "kode_study",
        "jenjang_study",
        "nama_study",
        "jurusan",
        "usia"
    ];

    public function NaikVerModel()
    {
        return $this->hasMany(NaikVerModel::class);
    }

    public function KgbVerModel()
    {
        return $this->hasMany(KgbVerModel::class);
    }

    public function cuti_ver_model()
    {
        return $this->hasMany(cuti_ver_model::class);
    }

    // public function NaikRekap()
    // {
    //     return $this->hasMany(NaikRekap::class);
    // }

    public function IjazahGelar()
    {
        return $this->hasMany(IjazahGelar::class);
    }

    public function Belajar()
    {
        return $this->hasMany(Belajar::class);
    }

    public function IstriSuami()
    {
        return $this->hasMany(IstriSuami::class);
    }

    public function PensiunVer()
    {
        return $this->hasMany(Pensiun::class);
    }

    public function Satyalencana()
    {
        return $this->hasMany(Satyalencana::class);
    }

    public function RekapPensiun()
    {
        return $this->hasMany(RekapPensiun::class);
    }

    public function RekapNaikPangkat()
    {
        return $this->hasMany(RekapNaikPangkat::class);
    }

    public function FileBahan()
    {
        return $this->hasMany(fileModel::class);
    }

    // penamaan fungsi mengikuti format sebagai berikut get{field pada table}Attribute
    // public function getAgamaAttribute($value)
    // {
    //     $agamaList = [
    //         1 => "ISLAM",
    //         2 => "KRISTEN",
    //         3 => "KATHOLIK",
    //         4 => "HINDU",
    //         5 => "BUDHA",
    //         6 => "LAINNYA",
    //     ];
    //     $a = $agamaList[$value];
    //     return ucwords(strtolower($a));
    // }


    // // untuk kode_status menjadi KodeStatus => format nama mengikuti format penulisan camel case
    // public function getStatusPnsAttribute($code)
    // {
    //     $StatusPNS = [
    //         1 => 'CPNS',
    //         2 => 'PNS',
    //         3 => 'P3K'
    //     ];
    //     return $StatusPNS[$code];
    // }

}





















