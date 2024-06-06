<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


Route::resource('posts', App\Http\Controllers\PostController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class)->only('store', 'show');

Route::get('reports', App\Http\Controllers\ReportController::class);
