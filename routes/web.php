<?php

use Illuminate\Support\Facades\Route;

Route::webhooks('webhooks/whatsapp');

Route::get('/', function () {
    return view('welcome');
});
