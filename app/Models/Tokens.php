<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    use HasFactory;
    protected $table = 'Tokens';
    protected $primaryKey = 'email';
    
    protected $fillable = [
        "email",
        'token',
        'created',
    ];
}
