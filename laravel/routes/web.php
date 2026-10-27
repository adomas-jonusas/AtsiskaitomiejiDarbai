<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index'])->name('home');
Route::view('/register', 'auth.register')->middleware('guest')->name('register');
Route::post('/register', Register::class)->middleware('guest')->name('register.store');
Route::post('/chirps', [ChirpController::class, 'store'])->name('chirps.store');
Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit'])->name('chirps.edit');
Route::put('/chirps/{chirp}', [ChirpController::class, 'update'])->name('chirps.update');
Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirps.destroy');
