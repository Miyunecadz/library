<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LogoutBasic;
use App\Http\Controllers\authentications\RegisterBasic;

Route::middleware('guest')->group(function () {
  Route::get('/login', [LoginBasic::class, 'index'])->name('auth.login');
  Route::post('/api/login', [LoginBasic::class, 'authenticate']);

  Route::get('/register', [RegisterBasic::class, 'index'])->name('auth.register');
  Route::post('/api/register', [RegisterBasic::class, 'register']);

  Route::post('/api/login/google', [LoginBasic::class, 'handleGoogleSignIn']);
});

Route::middleware('auth')->group(function () {
  Route::get('/api/logout', [LogoutBasic::class, 'index'])->name('auth.logout');
});
