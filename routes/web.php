<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AvailabilitySlotController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;

// Home → login
Route::get('/', fn() => redirect()->route('login'));

// Auth routes (manual - no Breeze)
Route::get('/login',    [App\Http\Controllers\Auth\LoginController::class, 'showForm'])->name('login');
Route::post('/login',   [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showForm'])->name('register');
Route::post('/register',[App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');
Route::post('/logout',  [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Dashboard (redirects by role)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // AJAX - available slots
    Route::get('/api/slots', [AvailabilitySlotController::class, 'getSlots'])->name('api.slots');

    // ── ADMIN ──────────────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users',     [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}/edit',    [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}',         [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}',      [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::get('/appointments',         [AppointmentController::class, 'adminIndex'])->name('appointments');
    });

    // Services – admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::post('services/{service}/toggle', [ServiceController::class, 'toggleStatus'])->name('services.toggle');
    });

    // ── STAFF ──────────────────────────────────────────────────
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
        Route::get('/slots',              [AvailabilitySlotController::class, 'index'])->name('slots.index');
        Route::get('/slots/create',       [AvailabilitySlotController::class, 'create'])->name('slots.create');
        Route::post('/slots',             [AvailabilitySlotController::class, 'store'])->name('slots.store');
        Route::delete('/slots/{slot}',    [AvailabilitySlotController::class, 'destroy'])->name('slots.destroy');
        Route::get('/appointments',       [AppointmentController::class, 'staffIndex'])->name('appointments');
        Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    });

    // ── CUSTOMER ────────────────────────────────────────────────
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard',     [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/book',          [AppointmentController::class, 'book'])->name('book');
        Route::post('/book',         [AppointmentController::class, 'store'])->name('book.store');
        Route::get('/appointments',  [AppointmentController::class, 'customerIndex'])->name('appointments');
        Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    });
});
