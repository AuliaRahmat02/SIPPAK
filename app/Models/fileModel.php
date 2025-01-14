<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class fileModel extends Model
{
    use HasFactory;

    protected $table = "file_models";
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'uuid';


    protected $fillable = [
        'ID',
        'nip_pegawai',
        'nama',
        'jenisBahan',
        'file',
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

    public function pegawai(){
        return $this->belongsTo(pegawai::class);
    }
}
