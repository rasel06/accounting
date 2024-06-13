<?php

use App\Livewire\AssetType;
use Illuminate\Support\Facades\Route;
use App\Livewire\PaymentMethod;
use App\Livewire\Locations;
use App\Livewire\Stores;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

Route::group(['middleware' => ['auth']], function () {
    // Route::get('/debit', PaymentMethod::class);
    // Route::get('/credit', AssetType::class);
});


Route::group(['prefix' => 'report', 'as' => 'report.', 'middleware' => ['auth']], function () {
    // Route::get('/payment-method', PaymentMethod::class);
    // Route::get('/asset-types', AssetType::class);
    // Route::get('/store', Stores::class);
    // Route::get('/location', Locations::class);
});


Route::group(['prefix' => 'settings', 'as' => 'settings.', 'middleware' => ['auth']], function () {
    Route::get('/payment-method', PaymentMethod::class);
    Route::get('/asset-types', AssetType::class);
    Route::get('/store', Stores::class);
    Route::get('/location', Locations::class);
});



// Route::resource('payment-methods', App\Http\Controllers\PaymentMethodController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);
