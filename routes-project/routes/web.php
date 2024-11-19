<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;
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
    Route::get('/user/profile', [UserController::class, 'index'])->name('user-dashboard');
    Route::get('/user/profile/edit', [UserController::class, 'indexEditProfile'])->name('edit.profile');
    Route::get('/routes', [UserController::class, 'prepareRoutes'])->name('routes');
    Route::any('/routes/selected', [UserController::class, 'selectRoute'])->name('selected.route');
    Route::get('/route/{routeId}/upload-images', [ImageController::class, 'index'])->name('upload-images.route');
    Route::post('/route/selected/signin', [UserController::class, 'signInForRoute'])->name('sign-route');
    Route::post('/route/selected/signout', [UserController::class, 'signOutForRoute'])->name('signout-route');
    Route::get('/routes/search', [UserController::class, 'search'])->name('routes.search');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
