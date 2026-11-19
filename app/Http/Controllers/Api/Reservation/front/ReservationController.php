<?php

namespace App\Http\Controllers\Api\Reservation\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Reservation\contract\ReservationServiceInterface;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\Reservation\CreateReservation;
use App\Models\Reservation;
use App\Http\Requests\Reservation\AdminCreateReservationRequest;

class ReservationController extends Controller{
    public function __construct(private ReservationServiceInterface $reservationService){}

    public function ViewReservation(Reservation $reservation){
        return new ReservationResource($reservation);
    }

    public function CreateReservation(CreateReservation $request){
        $data=$request->validated();

        $data['user_id']= auth()->id();

        return new ReservationResource($this->reservationService->createReservation($data));
    }

    public function UpdateReservation(Reservation $reservation, CreateReservation $request){
        $data=$request->validated();

        $data['user_id'] = auth()->id();

        return new ReservationResource($this->reservationService->UpdateReservation($reservation, $data));
    }

    public function DeleteReservation(Reservation $reservation){
        $this->reservationService->DeleteReservation($reservation);

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ]);
    }

    public function completeReservation(Reservation $reservation)
    {
        return new ReservationResource($this->reservationService->completeReservation($reservation));
    }

}