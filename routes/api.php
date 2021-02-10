<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FacilitieController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('user-info', [AuthController::class, 'getUser'])->name('auth.user-info');

    Route::apiResource('users', UserController::class)->except([
        'create', 'store'
    ]);

    Route::apiResource('members', MemberController::class);
    Route::get('members/{id}/bookings', [MemberController::class, 'reservations']);


    Route::apiResource('facilities', FacilitieController::class);
    Route::get('facilities/{id}/bookings', [FacilitieController::class, 'reservations']);


    Route::apiResource('bookings', BookingController::class);
});
