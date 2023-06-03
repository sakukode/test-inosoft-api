<?php

namespace App\Models;

use Database\Factories\MotorCycleFactory;

class MotorCycle extends Vehicle
{
    const TYPE = 'motorcycle';

    /**
     * Scope to filter vehicle by type
     * @return void
     */
    public static function boot(): void
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
            'suspension_type',
            'transmision_type',
        ]);
    }

    /**
     * Get vehicle's specification
     * @return array
     */
    public function getSpecificationAttribute(): array
    {
        return [
            'engine' => $this->engine,
            'suspension_type' => $this->suspension_type,
            'transmision_type' => $this->transmision_type,
        ];
    }

    /**
     * Override creating event to save specification to sub document
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->specification = $model->specification;

            $model->type = self::TYPE;
            unset($model->engine, $model->suspension_type, $model->transmision_type);
        });
    }

     /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return MotorCycleFactory::new();
    }
}