<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'location_id',
        'celestial_body_id',
        'date',
        'time',
        'sky_conditions',
        'description',
        'rating',
        'latitude',
        'longitude',
    ];
}
