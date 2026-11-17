<?php

namespace App\Services\Reservation\contract;

use Illuminate\Support\Collection;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;


interface ReservationServiceInterface
{
    public function ViewReservations(): Collection;
    public function ViewReservationById(int $reservationId): ?Reservation;
    public function ViewReservationByUser(User $user): Collection;
    public function ViewReservationByTable(Table $table): Collection;
    public function createReservation(array $data): ?Reservation;
    public function UpdateReservation(Reservation $reservation, array $data): ?Reservation;
    public function DeleteReservation(Reservation $reservation);
    
}
