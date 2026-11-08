<?php

namespace App\Repositories\Cart;

use Illuminate\Support\Collection;
use App\Models\Cart;
use App\Models\User;
use App\Repositories\Cart\Contract\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function ViewCarts(): Collection
    {
        return Cart::latest()->get();
    }

    public function ViewCart(int $id): ?Cart
    {
        return Cart::findOrFail($id);
    }

    public function CreateCart(User $user): Cart
    {
        return $user->Cart()->create();
    }

/*     public function UpdateCart(Cart $cart, array $data): Cart
    {
        return $cart->update($data);
    }

    public function DeleteCart(Cart $cart){
        return $cart->delete();
    } */

}
