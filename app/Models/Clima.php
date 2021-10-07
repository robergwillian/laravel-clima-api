<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clima extends Model
{

    public $timestamps = true;
    
    use HasFactory;

    protected $fillable = [
        'cidade',
        'temperatura',
    ];
}
