<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => inertia('Home'))->name('home');
Route::get('/welcome', fn () => inertia('Welcome'))->name('welcome');
