<?php

use App\Models\Business\Business;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Route\RouteController;
use App\Models\User;

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

Route::get('/test', function () {
    /*return auth()->user()->roles->pluck('name');*/
    return User::with('personal_information', 'business', 'roles')->where('id', '!=', 1)->where('business_id','=', auth()->user()->business_id )->get();
});

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'User'], function () {
        Route::get('/', [App\Http\Controllers\User\UserController::class, 'index'])->name('user.index');
        Route::get('/get', [App\Http\Controllers\User\UserController::class, 'get'])->name('user.get');
        Route::get('/delete/{user}', [App\Http\Controllers\User\UserController::class, 'delete'])->name('user.delete');
        Route::post('/store', [App\Http\Controllers\User\UserController::class, 'store'])->name('user.store');
        Route::post('/update/{user}', [App\Http\Controllers\User\UserController::class, 'update'])->name('user.update');

        Route::group(['prefix' => 'Role'], function () {
            Route::get('/get', [App\Http\Controllers\User\UserController::class, 'getRoles'])->name('user.role.get');
        });
    });

    Route::group(['prefix' => 'Business'], function () {
        Route::get('/', [BusinessController::class, 'index'])->name('business.index');
        Route::get('/get', [BusinessController::class, 'get'])->name('business.get');
        Route::post('/store', [BusinessController::class, 'store'])->name('business.store');
        Route::post('/update/{business}', [BusinessController::class, 'update'])->name('business.update');
        Route::post('/delete/{business}', [BusinessController::class, 'delete'])->name('business.delete');
        Route::get('/getCollectors/{business}', [BusinessController::class, 'getCollectors'])->name('business.getCollectors');
    });

    Route::group(['prefix' => 'Route'], function () {
        Route::get('/', [RouteController::class, 'index'])->name('route.index');
        Route::get('/get', [RouteController::class, 'get'])->name('route.get');
        Route::post('/store', [RouteController::class, 'store'])->name('route.store');
        Route::post('/update/{route}', [RouteController::class, 'update'])->name('route.update');
        Route::post('/delete/{route}', [RouteController::class, 'delete'])->name('route.delete');
    });
});
