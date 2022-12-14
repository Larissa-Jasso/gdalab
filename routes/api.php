<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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







Route::post('/login', [CustomerController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/customer', [CustomerController::class, 'CreateCustomer']);
    Route::get('/customer', [CustomerController::class, 'GetCustomer']);
    Route::delete('customer', [CustomerController::class, 'DeleteCustomer']);
});
