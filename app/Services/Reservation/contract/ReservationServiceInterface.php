<?php

namespace App\Services\Reservation\contract;

use Illuminate\Support\Collection;
use App\Models\Reservation;

interface ReservationServiceInterface
{
    public function ViewReservations(): Collection;
    public function ViewReservationById(int $reservationId): ?Reservation;
    public function ViewReservationByUser(int $userId): ?Reservation;
    public function ViewReservationByTable(int $tableId): ?Reservation;
    public function createReservation(int $userId, array $data): ?Reservation;
    public function UpdateReservation(int $reservationId, array $data): ?Reservation;
    public function DeleteReservation(int $reservationId);
}
