<?php

namespace App\Http\Controllers\Api\Reservation\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Reservation\contract\ReservationServiceInterface;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\Reservation\CreateReservation;
use App\Models\Reservation;
use App\Http\Requests\Reservation\AdminCreateReservationRequest;
use App\Models\User;
use App\Models\Table;
use App\Http\Requests\Reservation\AdminUpdateReservation;

class ReservationController extends Controller{
    public function __construct(private ReservationServiceInterface $reserveService){}

    public function adminViewReservations(){
        return ReservationResource::collection($this->reserveService->ViewReservations());
    }

    public function adminViewReservationById(Reservation $reservation){
        return new ReservationResource($reservation);
    }

    public function adminViewReservationByUser(User $user){
        return ReservationResource::collection($this->reserveService->ViewReservationByUser($user));
    }

    public function adminViewReservationByTable(Table $table){
        return ReservationResource::collection($this->reserveService->ViewReservationByTable($table));
    }

    public function adminCreateReservation(AdminCreateReservationRequest $request){
        $validatedrequest=$request->validated();

        return new ReservationResource($this->reserveService->createReservation($validatedrequest));
    }

    public function adminUpdateReservation(Reservation $reservation, AdminUpdateReservation $request){
        $validatedRequest=$request->validated();

        return new ReservationResource($this->reserveService->UpdateReservation($reservation, $validatedRequest));
    }

    public function adminDeleteReservation(Reservation $reservation){
        $this->reserveService->DeleteReservation($reservation);

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ]);
    }

    public function completeReservation(Reservation $reservation)
    {
        return new ReservationResource($this->reserveService->completeReservation($reservation));
    }

}
    
