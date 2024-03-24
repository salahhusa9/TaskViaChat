<?php

use App\Livewire\Numbers\Table;
use Illuminate\Support\Facades\Route;

Route::webhooks('webhooks/whatsapp');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('/numbers', 'numbers')->name('numbers');
});
