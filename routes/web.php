<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/home', [WelcomeController::class, 'destinations_list'])->name('home');

Route::redirect('/', '/home')->name('home');

Route::get('/booking/all', [SearchController::class, 'initial_state'])->name('booking');
// Route::post('/booking', [SearchController::class, 'destinations_result'])->name('booking');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'sort'])->name('dashboard.sort');

    // ------------------------------------------------------------------------------------------------

    Route::get('/booking/search', [SearchController::class, 'show_results'])->name('booking.results');
    Route::post('/booking/search', [SearchController::class, 'search'])->name('booking.search');

    Route::get('/booking/payment', [SearchController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/payment', [SearchController::class, 'payment'])->name('booking.payment');

    // ------------------------------------------------------------------------------------------------

    Route::get('/admin', [AdminController::class,'index'])->name('admin');

    Route::post('/admin/destinations/create', [AdminController::class,'create_destination'])->name('admin.create_destination');
    Route::put('/admin/destinations/edit', [AdminController::class,'edit_destination'])->name('admin.edit_destination');
    Route::delete('/admin/destinations/delete', [AdminController::class,'delete_destination'])->name('admin.delete_destination');

    Route::post('/admin/trains/create', [AdminController::class,'create_train'])->name('admin.create_train');
    Route::put('/admin/trains/edit', [AdminController::class,'edit_train'])->name('admin.edit_train');
    Route::put('/admin/trains/edit_destinations', [AdminController::class,'edit_train_destinations'])->name('admin.edit_train_destinations');
    Route::delete('/admin/trains/delete', [AdminController::class,'delete_train'])->name('admin.delete_train');
    
    // ------------------------------------------------------------------------------------------------
    
    Route::delete('/admin/users/delete', [AdminController::class,'delete_user'])->name('admin.delete_user');

    // Route::resource('dashboard', DashboardController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
