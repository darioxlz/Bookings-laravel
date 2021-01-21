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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user-info', [AuthController::class, 'getUser']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'delete']);


    Route::get('members', [MemberController::class, 'index']);
    Route::get('members/{id}', [MemberController::class, 'show']);
    Route::get('members/{id}/bookings', [MemberController::class, 'reservations']);
    Route::post('members', [MemberController::class, 'store']);
    Route::put('members/{id}', [MemberController::class, 'update']);
    Route::delete('members/{id}', [MemberController::class, 'delete']);


    Route::get('facilities', [FacilitieController::class, 'index']);
    Route::get('facilities/{id}', [FacilitieController::class, 'show']);
    Route::get('facilities/{id}/bookings', [FacilitieController::class, 'reservations']);
    Route::post('facilities', [FacilitieController::class, 'store']);
    Route::put('facilities/{id}', [FacilitieController::class, 'update']);
    Route::delete('facilities/{facilitie}', [FacilitieController::class, 'delete']);


    Route::get('bookings', [BookingController::class, 'index']);
    Route::get('bookings/{id}', [BookingController::class, 'show']);
    Route::post('bookings', [BookingController::class, 'store']);
    Route::put('bookings/{id}', [BookingController::class, 'update']);
    Route::delete('bookings/{id}', [BookingController::class, 'delete']);
});
