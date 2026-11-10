<?php

namespace App\Repositories\Reservation;

use Illuminate\Support\Collection;
use App\Models\Reservation;
use App\Repositories\Reservation\contract\ReservationRepositoryInterface;

class ReservationRepository implements ReservationRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function ViewReservations(): Collection
    {
        return Reservation::with('User')->with('Table')->latest()->get();
    }

    public function ViewReservationById(int $reserveId): ?Reservation
    {
        return Reservation::where('id', $reserveId)->findOrFail();
    }

    public function ViewReservationByUser(int $userId): ?Reservation
    {
        return Reservation::where('user_id', $userId)->findOrFail();
    }

    public function ViewReservationByTable(int $tableId): ?Reservation{
        return Reservation::where('table_id', $tableId)->findOrFail();
    }

    public function CreateReservation(array $data): Reservation
    {
        return Reservation::create($data);
    }

    public function UpdateReservation(Reservation $reservation, array $data): ?Reservation
    {
        $reservation->update($data);

        return $reservation;
    }

    public function DeleteReservation(Reservation $reservation): bool
    {
        return $reservation->delete();
    }

    public function CheckTableIsAvailble(int $tableId, string $startsAt, string $endsAt)
    {
        return Reservation::where('table_id', $tableId)->where(function ($query){
            $query->where('status', 'confirmed')->orWhere(function ($query){
                $query->where('status', 'pending')->where('payment_expires_at', '>', now());
            });
        })->where('starts_at', '<', $endsAt)->where('ends_at', '>', $startsAt)->exists();
    }
    
}
