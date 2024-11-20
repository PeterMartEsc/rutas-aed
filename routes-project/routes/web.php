<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
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
    Route::get('/admin/profile', [RouteController::class, 'index'])->name('dashboard');
    Route::get('/admin/{user}/edit', [AdminController::class, 'searchUserToEdit'])->name('admin.edit.user');
    Route::patch('/admin/update', [AdminController::class, 'editUser'])->name('admin.update.user');
    Route::delete('/admin/delete-user', [AdminController::class, 'deleteUser'])->name('delete-user');


});

/**
 * For users
 */
Route::middleware(['role:User'])->group(function () {
    Route::get('/user/profile', [RouteController::class, 'index'])->name('dashboard');
    Route::get('/user/profile/edit', [UserController::class, 'indexEditProfile'])->name('edit.profile');
    Route::put('/user/profile', [RouteController::class, 'indexUpdateData'])->name('dashboard.updated');

    Route::get('/routes', [RouteController::class, 'prepareRoutes'])->name('routes');
    //TODO: change to get/post
    Route::any('/routes/selected', [RouteController::class, 'selectRoute'])->name('selected.route');
    Route::get('/route/{routeId}/upload-images', [ImageController::class, 'index'])->name('upload-images.route');
    Route::post('/route/selected/signin', [RouteController::class, 'signInForRoute'])->name('sign-route');
    Route::post('/route/selected/signout', [RouteController::class, 'signOutForRoute'])->name('signout-route');
    Route::get('/routes/search', [RouteController::class, 'search'])->name('routes.search');
    Route::get('/create-route', [RouteController::class, 'createRouteView'])->name('create-route');
    Route::post('/create-route', [RouteController::class, 'createRoute'])->name('save-route');
    Route::get('/route/edit', [RouteController::class, 'searchRouteToEdit'])->name('edit-route');
    Route::put('/route/update', [RouteController::class, 'editRoute'])->name('update-route');
    Route::delete('/delete-route', [RouteController::class, 'deleteRoute'])->name('delete-route');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
