<?php

namespace App\Repositories\Cart\Contract;

use Illuminate\Support\Collection;
use App\Models\Cart;
use App\Models\User;

interface CartRepositoryInterface
{
    public function ViewCarts(): Collection;
    public function ViewCart(int $id): ?Cart;
    public function CreateCart(User $user): Cart;
}