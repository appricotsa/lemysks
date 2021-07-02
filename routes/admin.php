<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

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




Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/doLogin', [AuthController::class, 'do_login'])->name('admin.do_login');

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('{any}', function () {
        return view('backend.pages.dashboard');
    })->where('any', '.*');
});
