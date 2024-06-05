<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Registration and login routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Login Route with email verification check
Route::get('/login', function () {
    if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
        return redirect()->route('verification.notice')->with('warning', 'You need to verify your email before logging in.');
    }
    return view('auth.login');
})->middleware('guest')->name('login');

// Dashboard route protected by authentication and email verification middleware
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Profile routes protected by authentication middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Lock screen routes and middleware
Route::middleware(['auth', 'lockScreen'])->group(function () {
    // Protected routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Add other protected routes here
});

Route::get('/lock_screen', [LockScreenController::class, 'lockScreen'])->name('lock-screen');
Route::post('/unlock_screen', [LockScreenController::class, 'unlock'])->name('unlock');
Route::post('/manual_screen', [LockScreenController::class, 'manualLock'])->name('manual-lock');
Route::post('/auto_screen', [LockScreenController::class, 'autoLock'])->name('auto-lock');

// Email verification routes
Route::get('/verify-email-notice', function () {
    return view('auth.verify-email-notice');
})->middleware('auth')->name('verification.notice');

Route::get('/verify-email', function () {
    return redirect('/verify-email-notice');
})->middleware('auth')->name('verification.verify');
