<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CutiUp extends Model
{
    use HasFactory;
    protected $table = 'cuti_ups';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'uuid';


    protected $fillable = [
        'ID',
        'file_name',
        'file_type',
        'file_data',
        'nip',
        'jenis_file'];



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



