<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index'])->name('home');
Route::view('/register', 'auth.register')->middleware('guest')->name('register');
Route::post('/register', Register::class)->middleware('guest')->name('register.store');
Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::post('/login', Login::class)->middleware('guest')->name('login.store');
Route::middleware('auth')->group(function () {
    Route::post('/logout', Logout::class)->name('logout');
    Route::post('/chirps', [ChirpController::class, 'store'])->name('chirps.store');
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit'])->name('chirps.edit');
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update'])->name('chirps.update');
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirps.destroy');
});
