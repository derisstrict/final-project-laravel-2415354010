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

Route::get('customer/', [CustomerController::class, 'index']);       
Route::post('customer/', [CustomerController::class, 'store']);      
Route::get('customer/{id}', [CustomerController::class, 'show']);      
Route::put('customer/{id}', [CustomerController::class, 'update']);     
Route::delete('customer/{id}', [CustomerController::class, 'destroy']);  
Route::patch('customer/{id}/activate', [CustomerController::class, 'activate']);   
Route::patch('customer/{id}/deactivate', [CustomerController::class, 'deactivate']);

Route::apiResource('subscriptions', SubscriptionController::class);
