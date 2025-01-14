<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cuti_ver_model extends Model
{
    use HasFactory;

    protected $table = 'cuti_ver_models';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable=[
        'id',
        'nip',
        'fase',
        'verif',
        "jenis",
        "nomor",
        "hari",
        "mulai",
        "selesai",
        'nomorSurat',
        'pesan'
    ];


    // fungsi untuk membuat uuid pada field id
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function pegawai()
    {
        return $this->belongsTo(pegawai::class);
    }
}
