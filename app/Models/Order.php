<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\OrderFactory;
use DateTime;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\UTCDateTime;

class Order extends Model implements Arrayable
{
    use HasFactory;

    protected $fillable = [
        'date',
        'quantity',
        'price',
        'customer'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    public function setDateAttribute($value)
    {
        if($value instanceof UTCDateTime) {
            $value = $value;
        } else if($value instanceof DateTime){
            $value = new UTCDateTime($value->format('Uv'));
        } else {
            $value = new UTCDateTime(Carbon::createFromDate($value)->format('Uv'));
        }

        $this->attributes['date'] = $value;
    }
}
