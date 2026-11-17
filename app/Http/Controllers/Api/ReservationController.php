<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Reservation\contract\ReservationServiceInterface;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\Reservation\CreateReservation;
use App\Models\Reservation;
use App\Http\Requests\Reservation\AdminCreateReservationRequest;

class ReservationController extends Controller
{
    public function __construct(private ReservationServiceInterface $reserveService){}

    public function ViewReservation(Reservation $reservation){
        return new ReservationResource($reservation);
    }

    public function ViewReservationByUser(int $userId){
        return new ReservationResource($this->reserveService->ViewReservationByUser($userId));
    }

    public function ViewReservationByTable(int $tableId){
        return new ReservationResource($this->reserveService->ViewReservationByTable($tableId));
    }

    public function CreateReservation(CreateReservation $request){
        $data=$request->validated();

        $data['user_id']= auth()->id();

        return new ReservationResource($this->reserveService->createReservation($data));
    }

    public function UpdateReservation(Reservation $reservation, CreateReservation $request){
        $data=$request->validated();

        $data['user_id'] = auth()->id();

        return new ReservationResource($this->reserveService->UpdateReservation($reservation, $data));
    }

    public function DeleteReservation(Reservation $reservation){
        $this->reserveService->DeleteReservation($reservation);

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ]);
    }

    public function adminCreateReservation(AdminCreateReservationRequest $request){
        $validatedrequest=$request->validated();

        return new ReservationResource($this->reserveService->createReservation($validatedrequest));
    }

    public function adminUpdateReservation(Reservation $reservation, AdminCreateReservationRequest $request){
        $validatedRequest=$request->validated();

        return new ReservationResource($this->reserveService->UpdateReservation($reservation, $validatedRequest));
    }

    public function adminDeleteReservation(Reservation $reservation){
        $this->reserveService->DeleteReservation($reservation);

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ]);
    }
}
