<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SubscriptionController;

Route::apiResource("services", ServiceController::class);
Route::get('/', [ServiceController::class, 'index']);
Route::post('/', [ServiceController::class, 'store']);
Route::get('{service}', [ServiceController::class, 'show']);
Route::put('{service}', [ServiceController::class, 'update']);
Route::delete('{service}', [ServiceController::class, 'destroy']);
Route::patch("services/{service}/activate", [ServiceController::class,"activate",]);
Route::patch("services/{service}/deactivate", [ServiceController::class, "deactivate"]);

Route::apiResource('customers', CustomerController::class);
Route::patch('customers/{id}/activate', [CustomerController::class, 'activate']);   
Route::patch('customers/{id}/deactivate', [CustomerController::class, 'deactivate']);

Route::apiResource('subscriptions', SubscriptionController::class);
