<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrolModel extends Model
{
    use HasFactory;
    // protected $primaryKey = 'NIP';
    protected $table = 'kontrol';

    // Nama kolom primary key yang digunakan
    protected $primaryKey = 'set';

    // Jika primary key bukan auto-incrementing
    public $incrementing = false;

    // Jika primary key bukan tipe integer
    protected $keyType = 'string';

    protected $fillable = [
        'set',
        'code'
    ];
}
