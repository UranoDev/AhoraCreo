<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

// Landing Page (public)
Route::get('/', [SubscriberController::class, 'landing'])->name('landing');
Route::get('/ebook-cover', [SubscriberController::class, 'cover'])->name('ebook.cover');
Route::post('/subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');

// Email Verification & Download (public)
Route::get('/subscriber/verify/{token}', [SubscriberController::class, 'verify'])
    ->where('token', '[a-zA-Z0-9]{64}')
    ->name('subscriber.verify');
Route::get('/subscriber/download/{subscriber}/{token}', [SubscriberController::class, 'download'])
    ->name('subscriber.download');

// Dashboard redirect to admin
Route::get('/dashboard', function () {
    return redirect()->route('admin.subscribers');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Panel
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/subscribers', [AdminController::class, 'subscribers'])->name('admin.subscribers');
});

// Profile (Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
