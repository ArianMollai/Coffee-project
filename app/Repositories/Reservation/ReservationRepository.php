<?php

namespace App\Repositories\Reservation;

use Illuminate\Support\Collection;
use App\Models\Reservation;
use App\Repositories\Reservation\contract\ReservationRepositoryInterface;
use App\Models\User;
use App\Models\Table;

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
        return Reservation::with('User')->with('Table')->where('id', $reserveId)->findOrFail();
    }

    public function ViewReservationByUser(User $user): Collection
    {
        return $user->Reservations()->with('User')->with('Table')->get();
    }

    public function ViewReservationByTable(Table $table): Collection
    {
        return $table->Reservations()->with('User')->with('Table')->get();
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

    public function CheckTableIsAvailble(int $tableId, string $startsAt, string $endsAt, int $ignoreReservationId=null)
    {
        return Reservation::where('table_id', $tableId)->when($ignoreReservationId, function($query) use ($ignoreReservationId){
            $query->where('id' , '!=' , $ignoreReservationId);
        })->where(function ($query){
            $query->where('status', 'confirmed')->orWhere(function ($query){
                $query->where('status', 'pending')->where('payment_expires_at', '>', now());
            });
        })->where('starts_at', '<', $endsAt)->where('ends_at', '>', $startsAt)->exists();
    }
}
