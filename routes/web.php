<?php

use App\Livewire\Stores;
use App\Livewire\AssetType;
use App\Livewire\Locations;
use App\Livewire\PaymentMethod;
use App\Livewire\BusinessLocation;
use App\Livewire\DebitTransaction;
use App\Livewire\CreditTransaction;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

Route::group(['middleware' => ['auth']], function () {
    Route::get('/debit-transaction', DebitTransaction::class);
    Route::get('/credit-transaction', CreditTransaction::class);
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
    Route::get('/business-location', BusinessLocation::class);
});



// Route::resource('payment-methods', App\Http\Controllers\PaymentMethodController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);
