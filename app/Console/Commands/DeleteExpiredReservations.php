<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Reservation;

class DeleteExpiredReservations extends Command
{
    protected $signature="reservations:delete-expired";
    protected $description= "Delete expired pending reservations";

    public function handle()
    {
        $deletedCount=Reservation::where('status', 'pending')-> where('payment_expires_at', '<=', now())->delete();

        $this->info("Deleted {$deletedCount} expired reservation");

        return self::SUCCESS;
    }
}
