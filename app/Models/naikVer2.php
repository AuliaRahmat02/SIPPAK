<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class naikVer2 extends Model
{
    use HasFactory;

    protected $table = 'naik_ver2s';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable=[
        'ID',
        'nomor_surat',
        'nama_surat',
        'periode',
        'jenis_surat',
        'tanggal',
        'fase',
        'tolak',
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

    public function NaikVerModel()
    {
        return $this->belongsTo(NaikVerModel::class);
    }

    public function Satyalencana()
    {
        return $this->belongsTo(Satyalencana::class);
    }

    public function Pensiun()
    {
        return $this->belongsTo(Pensiun::class);
    }

    public function Ijazah()
    {
        return $this->belongsTo(IjazahGelar::class);
    }

    public function Kartu()
    {
        return $this->belongsTo(IstriSuami::class);
    }
}
