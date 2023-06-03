<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $collection = 'vehicles';

    protected $fillable = [
        'year',
        'color',
        'price',
        'type',
        'specification',
        'stocks'
    ];

    public $appends = ['stock'];

    /**
     * Get vehicle's stock
     * @return int
     */
    public function getStockAttribute(): int
    {
        return $this->stocks ? collect($this->stocks)->sum('quantity') : 0;
    }
}