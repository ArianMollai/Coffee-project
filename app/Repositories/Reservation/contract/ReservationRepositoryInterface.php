<?php

namespace App\Repositories\Reservation\contract;

use Illuminate\Support\Collection;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;

interface ReservationRepositoryInterface
{
    public function ViewReservations(): Collection;
    public function ViewReservationById(int $reserveId): ?Reservation;
    public function ViewReservationByUser(User $user): Collection;
    public function ViewReservationByTable(Table $table): Collection;
    public function CreateReservation(array $data): Reservation;
    public function UpdateReservation(Reservation $reservation, array $data): ?Reservation;
    public function DeleteReservation(Reservation $reservation): bool;
    public function CheckTableIsAvailble(int $tableId, string $startsAt, string $endsAt);
}
