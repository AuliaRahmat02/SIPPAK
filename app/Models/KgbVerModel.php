<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KgbVerModel extends Model
{
    use HasFactory;

    protected $table = 'kgb_ver_models';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable=[
        'id',
        'nip',
        'fase',
        'verif',
        'gajiBaru',
        'gajiLama',
        'noSurat',
        'suratSK',
        'noSK',
        'pesan'
    ];

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
