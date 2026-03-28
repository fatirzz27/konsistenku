<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Habits (CRUD)
    Route::resource('habits', HabitController::class);

    // Open reminder link from email safely
    Route::get('/reminders/{habit}', [HabitController::class, 'openReminder'])->name('reminders.open');

    // Check-in (fitur utama)
    Route::post('/habits/{habit}/checkin', [HabitController::class, 'checkin'])->name('habits.checkin');

    // Achievements
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
});

require __DIR__ . '/auth.php';