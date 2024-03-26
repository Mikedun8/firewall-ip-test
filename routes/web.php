<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckGeoLocation;

Route::view('/', 'welcome')->middleware(CheckGeoLocation::class);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('requests', 'livewire.credit_requests.requests')
    ->name('requests');

Route::view('credit-request', 'livewire.credit_requests.create-credit-request')
    ->name('credit-request');

require __DIR__.'/auth.php';
