<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', [HomeController::class, 'adminHome'])->name('admin.home');

    // User Module
    Route::resource('user', UserController::class);
    Route::get('userimage/{filename}', [UserController::class, 'displayUserImage'])->name('adminimage.displayUserImage');
    Route::post('/user/active-deactive', [UserController::class, 'ActiveDeactiveStatus'])->name('admin.user.active-deactive');

    // Error Handler
    // Route::get('/error-logs', [UserController::class, 'getErrorLogs'])->name('admin.user.error_log');

    // Error Handler
    Route::get('/api/error-logs', [UserController::class, 'getErrorLogs'])->name('error_log');
    Route::get('/api/error-logs/list', [UserController::class, 'getErrorLogsList']);
    // Route::get('/api/error-logs', 'UserController@getErrorLogs');
    // Route::get('/api/error-logs/list', 'UserController@getErrorLogsList');




    Route::get('user/{user}', [ UserController::class, 'listUserType' ])->name('userType-wise');
});


