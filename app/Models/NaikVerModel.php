<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NaikVerModel extends Model
{
    use HasFactory;

    protected $table = 'naik_ver_models';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable=[
        'id',
        'nip',
        'surat',
        'fase',

    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();  // Mengenerate UUID
            }
        });
    }

    public function naikVer2()
    {
        return $this->hasMany(naikVer2::class);
    }
}
