<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SubscriptionController;

Route::name('api.')->group(function () {
    Route::apiResource("services", ServiceController::class);
    Route::patch("services/{service}/activate", [ServiceController::class, "activate"])->name('services.activate');
    Route::patch("services/{service}/deactivate", [ServiceController::class, "deactivate"])->name('services.deactivate');

    Route::apiResource('customers', CustomerController::class);
    Route::patch('customers/{id}/activate', [CustomerController::class, 'activate'])->name('customers.activate');
    Route::patch('customers/{id}/deactivate', [CustomerController::class, 'deactivate'])->name('customers.deactivate');

    Route::apiResource('subscriptions', SubscriptionController::class);
});
