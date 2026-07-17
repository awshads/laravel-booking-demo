<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\BookingController;

Route::inertia('/', 'auth/login')->name('Login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [FacilityController::class, 'index'])->name('dashboard');

    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
    Route::post('facilities', [FacilityController::class, 'store'])->name('facilities.store');
    Route::get('facilities/{facility}/edit', [FacilityController::class, 'edit'])->name('facilities.edit');
    Route::patch('facilities/{facility}', [FacilityController::class, 'update'])->name('facilities.update');
    Route::delete('facilities/{facility}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

    Route::get('bookings/pending', [BookingController::class, 'pending'])->name('bookings.pending');
    Route::get('bookings/user', [BookingController::class, 'user'])->name('bookings.user');
    Route::post('bookings/{facility}/book', [BookingController::class, 'book'])->name('bookings.book');
    Route::patch('bookings/{booking}/review', [BookingController::class, 'review'])->name('bookings.review');
});

require __DIR__.'/settings.php';
