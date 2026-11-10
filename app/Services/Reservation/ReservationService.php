<?php

namespace App\Services\Reservation;

use App\Repositories\Reservation\contract\ReservationRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Table\Contract\TableServiceInterface;
use App\Services\Reservation\contract\ReservationServiceInterface;
use Exception;

class ReservationService implements ReservationServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private ReservationRepositoryInterface $reserveRepository,
        private TableServiceInterface $tableService
        )
    {}

    public function ViewReservations(): Collection
    {
        return $this->reserveRepository->ViewReservations();
    }

    public function ViewReservationById(int $reservationId): ?Reservation
    {
        return $this->reserveRepository->ViewReservationById($reservationId) ?? throw new ModelNotFoundException("No reservation found");
    }

    public function ViewReservationByUser(int $userId): ?Reservation
    {
        return $this->reserveRepository->ViewReservationByUser($userId) ?? throw new ModelNotFoundException("No reservation found");
    }

    public function ViewReservationByTable(int $tableId): ?Reservation
    {
        return $this->reserveRepository->ViewReservationByTable($tableId) ?? throw new ModelNotFoundException("No reservation found");
    }

    public function createReservation(int $userId, array $data): ?Reservation
    {
        if($this->reserveRepository->CheckTableIsAvailble($data['table_id'])){
            throw new Exception("Selected table is reserved");
        }
        
        $tablePrice=$this->tableService->FindTablePrice($data['table_id']) ?? throw new ModelNotFoundException("There is no price for this table");

        return $this->reserveRepository->CreateReservation([
            'user_id' => $userId,
            'table_id' => $data['table_id'],
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'payment_expires_at' => now()->addMInutes(30),
            'prica' => $tablePrice
        ]);
    }

    public function UpdateReservation(int $reservationId, array $data): ?Reservation
    {
        $reservation=$this->reserveRepository->ViewReservationById($reservationId) ?? throw new ModelNotFoundException("There is no price for this table");

        if($this->reserveRepository->CheckTableIsAvailble($data['table_id'])){
            throw new Exception("Selected table is reserved");
        }

        return $this->reserveRepository->UpdateReservation($reservation, [
            'user_id' => $data['user_id'],
            'table_id' => $data['table_id'],
            

        ]);
    }

    public function DeleteReservation(int $reservationId){
        $reservation=$this->ViewReservationById($reservationId) ?? throw new ModelNotFoundException("There is no price for this table");

        return $this->reserveRepository->DeleteReservation($reservation);
    }
}
