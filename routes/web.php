<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\ServiceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\CalendarController;
use Illuminate\Support\Facades\Route;

// ── Public Landing Page ───────────────────────────────────────────────────────
Route::get('/', [LandingController::class, 'index'])->name('home');

// ── Auth Routes (Breeze) ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// ── User Area ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'user.role'])->prefix('user')->name('user.')->group(function () {

    // Dashboard (Room Facilities)
    Route::get('dashboard', [UserDashboard::class, 'index'])->name('dashboard');

    // Wishlist
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('wishlist/remove/{item}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::delete('wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

    // Transactions / Booking Flow
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('transactions/update-quantity/{item}', [TransactionController::class, 'updateQuantity'])->name('transactions.update-quantity');
    Route::delete('transactions/remove/{item}', [TransactionController::class, 'removeItem'])->name('transactions.remove');
    Route::post('transactions/set-dates', [TransactionController::class, 'setDates'])->name('transactions.set-dates');
    Route::get('transactions/room-select', [TransactionController::class, 'showRoomSelect'])->name('transactions.room-select');
    Route::post('transactions/select-rooms', [TransactionController::class, 'selectRooms'])->name('transactions.select-rooms');
    Route::get('transactions/confirm', [TransactionController::class, 'showConfirm'])->name('transactions.confirm');
    Route::post('transactions/order', [TransactionController::class, 'order'])->name('transactions.order');

    // Booking History
    Route::get('bookings', [TransactionController::class, 'history'])->name('bookings');
    Route::get('bookings/{booking}', [TransactionController::class, 'show'])->name('bookings.show');

    // Hotel Service Numbers
    Route::get('services', [ServiceController::class, 'index'])->name('services');
});

// ── Admin Area ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // User Management
    Route::get('users', [AdminUserController::class, 'index'])->name('users');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Transaction Monitoring
    Route::get('transactions', [AdminTransactionController::class, 'index'])->name('transactions');
    Route::get('transactions/{booking}', [AdminTransactionController::class, 'show'])->name('transactions.show');
    Route::patch('transactions/{booking}/status', [AdminTransactionController::class, 'updateStatus'])->name('transactions.update-status');

    // Manual Reservation
    Route::get('reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('reservations/available-rooms', [ReservationController::class, 'availableRooms'])->name('reservations.available-rooms');

    // Booking Calendar
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('calendar/data', [CalendarController::class, 'data'])->name('calendar.data');
});
