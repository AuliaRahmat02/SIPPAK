<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;
    protected $table = 'histories';
    protected $primaryKey = 'ID_Histori';

    public $incrementing = false;
    protected $fillable = [
        'NIP',
        'Nama',
        'Keterangan'];

        protected static function boot()
        {
            parent::boot();
            static::creating(function ($model) {
                if (empty($model->ID_Histori)) {
                    $model->ID_Histori = (string) Str::uuid();  // Mengenerate UUID
                }
            });
        }
}
