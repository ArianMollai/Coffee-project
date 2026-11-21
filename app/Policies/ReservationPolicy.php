<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    public function adminviewAnyReservation(User $user):bool
    {
        if($user->level === "creator"){
            return true;
        }

        return $user->HasPermission('view-reservations');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function adminviewReservation(User $user): bool
    {
        if($user->level==="creator"){
            return true;
        }

        return $this->HasPermission('view-reservations');
    }

    /**
     * Determine whether the user can create models.
     */
    public function adminCreateReservation(User $user): bool
    {
        if($user->level === "creator"){
            return true;
        }

        return $user->HasPermission('create-reservations');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function adminUpdateReservation(User $user): bool
    {
        if($user->level === "creator"){
            return true;
        }

        return $user->HasPermission('update-reservations');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function adminDeleteReservation(User $user): bool
    {
        if($user->level === "creator"){
            return true;
        }

        return $user->HasPermission('delete-reservations');
    }

    public function adminCompleteReservation(User $user): bool
    {
        if($user->level=== "creator"){
            return true;
        }

        return $user->HasPermission('complete-reservations');
    }

    public function viewReservations(User $user, Reservation $reservation):bool
    {
        return $user->id === $reservation->user_id;
    }

    public function createReservation(User $user): bool
    {
        return true;
    }

    public function updateReservation(User $user, Reservation $reservation){
        return $user->id == $reservation->user_id;
    }

    public function deleteReservation(User $user, Reservation $reservation){
        return $user->id == $reservation->user_id;
    }

    public function completeReservation(User $user, Reservation $reservation): bool
    {
        return $user->id == $reservation->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $reservation): bool
    {
        return false;
    }
}
