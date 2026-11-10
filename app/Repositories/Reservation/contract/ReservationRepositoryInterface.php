<?php

namespace App\Repositories\Reservation\contract;

use Illuminate\Support\Collection;
use App\Models\Reservation;

interface ReservationRepositoryInterface
{
    public function ViewReservations(): Collection;
    public function ViewReservationById(int $reserveId): ?Reservation;
    public function ViewReservationByUser(int $userId): ?Reservation;
    public function ViewReservationByTable(int $tableId): ?Reservation;
    public function CreateReservation(array $data): Reservation;
    public function UpdateReservation(Reservation $reservation, array $data): ?Reservation;
    public function DeleteReservation(Reservation $reservation): bool;
    public function CheckTableIsAvailble(int $tableId);
}
