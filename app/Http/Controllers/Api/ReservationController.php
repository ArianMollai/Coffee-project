<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Reservation\contract\ReservationServiceInterface;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\Reservation\CreateReservation;

class ReservationController extends Controller
{
    public function __construct(private ReservationServiceInterface $reserveService){}

    public function ViewReservations(){
        return ReservationResource::collection($this->reserveService->ViewReservations());
    }

    public function ViewReservationById(int $reserveId){
        return new ReservationResource($this->reserveService->ViewReservationById());
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

    public function UpdateReservation(int $reserveId, CreateReservation $request){
        return new ReservationResource($this->reserveService->UpdateReservation($reserveId, $request->validated()));
    }

    public function DeleteReservation(int $reserveId){
        $this->reserveService->DeleteReservation($reserveId);

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ]);
    }
}
