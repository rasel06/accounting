<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PaymentMethod;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';



Route::get('/payment-method', PaymentMethod::class);



// Route::resource('payment-methods', App\Http\Controllers\PaymentMethodController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);
