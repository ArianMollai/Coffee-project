<?php

namespace App\Services\Cart\Contract;

use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Cart;

interface CartServiceInterface
{
    public function ViewCarts(): Collection;
    public function ViewCart(int $id): ?Cart;
    public function CreateCart(User $user): Cart;
}
