<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\OrderReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {

    Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('/vehicles/{id}/order-reports', [OrderReportController::class, 'index'])->name('vehicles.order_reports.index');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    
});
