<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Cart\Contract\CartServiceInterface;

class CreateCartForUser
{
    /**
     * Create the event listener.
     */
    public function __construct(private CartServiceInterface $cartService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $this->cartService->CreateCart($event->user);
    }
}
