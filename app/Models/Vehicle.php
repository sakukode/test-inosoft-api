<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Vehicle extends Model
{
    protected $collection = 'vehicles';

    protected $fillable = [
        'year',
        'color',
        'price',
        'vehicle_type',
        'specification',
        'stocks',
        'orders'
    ];
}