<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The name of the collection associated with the model.
     *
     * @var string
     */
    protected $collection = 'vehicles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'color',
        'price',
        'type',
        'specification',
        'stocks',
        'orders',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    public $appends = ['stock', 'orders'];

    /**
     * Get the vehicle's stock.
     *
     * @return int
     */
    public function getStockAttribute(): int
    {
        return $this->stocks ? collect($this->stocks)->sum('quantity') : 0;
    }

    /**
     * Get the vehicle's orders.
     *
     * @param $value
     * @return Collection
     */
    public function orders()
    {
        return $this->embedsMany(Order::class);
    }
}
