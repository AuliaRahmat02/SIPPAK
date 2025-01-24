<?php

namespace App\Models;

use Illuminate\Support\Str;
// use Illuminate\Database\Eloquent\Model dsds;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class users extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'ID_User';
    public $incrementing = false;
    protected $keyType = 'uuid';


    protected $fillable = [
        'ID_User',
        'NIP_User',
        'Nama_User',
        'Password',
        'opadpim',
        'email',
        'biro',
        'jft',
        'kabag',
        'kabiro',
        'ttd',
    ];


    // Menghasilkan UUID secara otomatis saat membuat model
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected $hidden = [
        'Password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    //mebuat convert biro
    public function getBiroAttribute($value)
    {
        $BiroList = [
            0 => "Admin",
            1 => "Biro Pemerintahan dan Otonomi Daerah",
            2 => "Biro Hukum",
            3 => "Biro Administrasi Pimpinan",
            4 => "Biro Kesejahteraan Rakyat",
            5 => "Biro Perekonomian",
            6 => "Biro Administrasi Pembangunan",
            7 => "Biro Organisasi",
            8 => "Biro Umum",
            9 => "Biro Pengadaan Barang dan Jasa",
        ];
        $a = $BiroList[$value];
        return $a;
    }
}




