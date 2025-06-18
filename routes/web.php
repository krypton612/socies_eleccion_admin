<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect::to('/control/login');
});

Route::get('/login', function () {
    return Redirect::to('/control/login2');
})->name('login');