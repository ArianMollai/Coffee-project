<?php

namespace App\Services\Reservation;

use App\Repositories\Reservation\contract\ReservationRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Table\Contract\TableServiceInterface;
use App\Services\Reservation\contract\ReservationServiceInterface;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Table;
use Illuminate\Support\Facades\DB;

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

    public function ViewReservationByUser(User $user): Collection
    {
        return $this->reserveRepository->ViewReservationByUser($user) ?? throw new ModelNotFoundException("No reservation found");
    }

    public function ViewReservationByTable(table $table): collection
    {
        return $this->reserveRepository->ViewReservationByTable($table) ?? throw new ModelNotFoundException("No reservation found");
    }

    public function createReservation(array $data): ?Reservation
    {
        $startsAt=Carbon::parse($data['starts_at']);
        $endsAt=$startsAt->copy()->addMinutes(120);

        if($this->reserveRepository->CheckTableIsAvailble($data['table_id'], $startsAt, $endsAt)){
            throw new Exception("Selected table is reserved");
        }
        
        $tablePrice=$this->tableService->FindTablePrice($data['table_id']) ?? throw new ModelNotFoundException("There is no price for this table");

        return DB::transaction(function () use ($data, $startsAt, $endsAt, $tablePrice){
            return $this->reserveRepository->CreateReservation([
                'user_id' => $data['user_id'],
                'table_id' => $data['table_id'],
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'payment_expires_at' => now()->addMInutes(30),
                'status' => $data['status'] ?? 'pending',
                'price' => $tablePrice->final_price,
            ])->load(['User', 'Table']);
        });
    }

    public function UpdateReservation(Reservation $reservation, array $data): ?Reservation
    {
        $startsAt=Carbon::parse($data['starts_at']);
        $endsAt=$startsAt->copy()->addMInutes(120);
        //$reservation=$this->reserveRepository->ViewReservationById($reservationId) ?? throw new ModelNotFoundException("There is no price for this table");

        if($this->reserveRepository->CheckTableIsAvailble($data['table_id'], $startsAt, $endsAt, $reservation->id)){
            throw new Exception("Selected table is reserved");
        }

        return DB::transaction(function () use ($data, $startsAt, $endsAt, $reservation){
            return $this->reserveRepository->UpdateReservation($reservation, [
                'user_id' => $data['user_id'],
                'table_id' => $data['table_id'],
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'payment_expires_at' => $reservation->payment_expires_at,
                'status' => $data['status'] ?? $reservation->status,
                'price' => $reservation->price
            ])->load(['User', 'Table']);

        });
    }

    public function DeleteReservation(Reservation $reservation){
        return $this->reserveRepository->DeleteReservation($reservation);
    }

    public function completeReservation(Reservation $reservation): Reservation
    {
        if($reservation->status !== 'pending'){
            throw new Exception("Cant confirm this reservation");
        }

        return $this->reserveRepository->UpdateReservation($reservation, ['status' => 'confirmed', 'payment_expires_at' => null]);
    }
}
