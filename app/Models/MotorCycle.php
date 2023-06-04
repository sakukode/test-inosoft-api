<?php

namespace App\Models;

use Database\Factories\MotorCycleFactory;

class MotorCycle extends Vehicle
{
    const TYPE = 'motorcycle';

    /**
     * Boot the MotorCycle model.
     *
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
    public function getFillable(): array
    {
        return array_merge(parent::getFillable(), [
            'engine',
            'suspension_type',
            'transmision_type',
        ]);
    }

    /**
     * Get the MotorCycle's specification attribute.
     *
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
     * Override creating event to save specification to sub document.
     *
     * @return void
     */
    protected static function booted(): void
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
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return MotorCycleFactory::new();
    }
}
