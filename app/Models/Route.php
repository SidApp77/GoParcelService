<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    //
    protected $fillable = [
        'origin',
        'destination',
        'distance',
        'departure_time',
        'arrival_time',
        'status',
    ];
}
