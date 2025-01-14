<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IstriSuami extends Model
{
    use HasFactory;

    protected $table = 'istri_suamis';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'nip',
        'surat',
        'fase',
        'tolak',
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

    public function pegawai(){
        return $this->belongsTo(pegawai::class);
    }

    public function naikVer2()
    {
        return $this->hasMany(naikVer2::class);
    }
}
