<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Reservation\admin\ReservationController;
use App\Models\Reservation;

Route::middleware(['jwt', 'throttle:api'])->group(function(){
    Route::get('/V1/admin/reservations', [ReservationController::class, 'adminViewReservations'])->middleware('can:adminviewAnyReservation,' .Reservation::class);
    Route::get('/V1/admin/reservations/{reservation}', [ReservationController::class, 'adminViewReservationById'])->middleware('can:adminviewReservation,' .Reservation::class);
    Route::get('/V1/admin/reservation/user/{user}', [ReservationController::class, 'adminViewReservationByUser'])->middleware('can:adminviewReservation,' .Reservation::class);
    Route::get('V1/admin/reservation/table/{table}', [ReservationController::class, 'adminViewReservationByTable'])->middleware('can:adminviewReservation,' .Reservation::class);
    Route::post('/V1/admin/reservations/create', [ReservationController::class, 'adminCreateReservation'])->middleware('can:adminCreateReservation,' .Reservation::class);
    Route::put('/V1/admin/reservations/update/{reservation}', [ReservationController::class, 'adminUpdateReservation'])->middleware('can:adminUpdateReservation,' .Reservation::class);
    Route::delete('/V1/admin/reservations/delete/{reservation}', [ReservationController::class, 'adminDeleteReservation'])->middleware('can:adminDeleteReservation,' .Reservation::class);
    Route::put('/V1/admin/reservations/complete/{reservation}', [ReservationController::class, 'completeReservation'])->middleware('can:adminCompleteReservation,' .Reservation::class);
});