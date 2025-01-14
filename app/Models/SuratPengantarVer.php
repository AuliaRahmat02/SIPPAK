<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratPengantarVer extends Model
{
    use HasFactory;

    protected $table = 'surat_pengantar_vers';
    protected $primaryKey = 'id_surat';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id_surat',
        'nama_surat',
        'nomor_surat',
        'file',
        'jenis',
        'biro',

    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
