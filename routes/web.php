<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return redirect()->route('customers.index');
});

// Customer Routes
Route::resource('customers', CustomerController::class);
Route::patch('customers/{id}/activate', [CustomerController::class, 'activate'])->name('customers.activate');
Route::patch('customers/{id}/deactivate', [CustomerController::class, 'deactivate'])->name('customers.deactivate');

// Service Routes
Route::resource('services', ServiceController::class);
Route::patch('services/{id}/activate', [ServiceController::class, 'activate'])->name('services.activate');
Route::patch('services/{id}/deactivate', [ServiceController::class, 'deactivate'])->name('services.deactivate');

// Subscription Routes
Route::resource('subscriptions', SubscriptionController::class);
