<?php

namespace App\Models;

use Database\Factories\CarFactory;

class Car extends Vehicle
{
    const TYPE = 'car';

    /**
     * Scope to filter vehicle by type
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('type', self::TYPE);
        });
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable()
    {
        return array_merge(parent::getFillable(), [
            'engine',
            'seat',
            'type',
        ]);
    }

    /**
     * Get vehicle's specification.
     *
     * @return array
     */
    public function getSpecificationAttribute(): array
    {
        return [
            'engine' => $this->engine,
            'seat' => $this->seat,
            'type' => $this->type,
        ];
    }

    /**
     * Override creating event to save specification to sub document.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->specification = $model->specification;
            unset($model->engine, $model->seat, $model->type);
            $model->type = self::TYPE;
        });
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CarFactory::new();
    }
}
