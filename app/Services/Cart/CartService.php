<?php

namespace App\Services\Cart;

use Illuminate\Support\Collection;
use App\Models\Cart;
use App\Models\User;
use App\Repositories\Cart\Contract\CartRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Services\Cart\Contract\CartServiceInterface;


class CartService implements CartServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CartRepositoryInterface $cartRepository)
    {
        //
    }

    public function ViewCarts(): Collection
    {
        return $this->cartRepository->ViewCarts();
    }

    public function ViewCart(int $id): ?Cart
    {
        return $this->cartRepository->ViewCart($id) ?? throw new ModelNotFoundException("Cart not found");
    }

    public function CreateCart(User $user): Cart
    {
        return $this->cartRepository->CreateCart($user);
    }
}
