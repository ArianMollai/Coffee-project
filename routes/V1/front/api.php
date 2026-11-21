<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Reservation\front\ReservationController;
use App\Models\Reservation;

Route::middleware(['jwt', 'throttle:api'])->group(function (){
    Route::get('/V1/front/reservations/{reservation}', [ReservationController::class, 'ViewReservation'])->middleware('can:viewReservations,reservation,' .Reservation::class);
    Route::post('/V1/front/reservations/create', [ReservationController::class, 'CreateReservation'])->middleware('can:createReservation,' .Reservation::class);
    Route::put('/V1/front/reservations/update/{reservation}', [ReservationController::class, 'UpdateReservation'])->middleware('can:updateReservation,reservation,' .Reservation::class);
    Route::delete('/V1/front/reservations/delete/{reservation}', [ReservationController::class, 'DeleteReservation'])->middleware('can:deleteReservation,reservation,' .Reservation::class);
    Route::patch('/V1/front/reservations/complete/{reservation}', [ReservationController::class, 'completeReservation'])->middleware('can:completeReservation,reservation,' .Reservation::class);
});