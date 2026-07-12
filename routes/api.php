<?php

use App\Http\Controllers\ParcelController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/parcels', [ParcelController::class, 'geoJson'])->name('api.parcels.geojson');
Route::post('/paystack/webhook', [PaymentController::class, 'webhook'])->name('api.paystack.webhook');
