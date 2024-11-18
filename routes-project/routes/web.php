<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/register');
});


/**
 * For administration
 */
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/admin/profile', [AdminController::class, 'index'])->name('admin-profile');
});

/**
 * For users
 */
Route::middleware(['role:User'])->group(function () {
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user-dashboard');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/PrProfile', function () {
    return view('profile');
});



require __DIR__.'/auth.php';
