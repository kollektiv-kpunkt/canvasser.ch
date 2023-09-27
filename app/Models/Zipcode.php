<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'zipcode',
        'city',
        'state',
        'bfsnr',
        'geoShape',
        'population',
    ];

    protected $casts = [
        'geoShape' => 'array',
    ];
}
