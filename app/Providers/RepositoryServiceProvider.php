<?php

namespace App\Providers;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Orders\EloquentMongoOrderRepository;
use App\Repositories\Vehicles\EloquentMongoVehicleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VehicleRepositoryInterface::class, EloquentMongoVehicleRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, EloquentMongoOrderRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
