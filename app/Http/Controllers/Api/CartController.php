<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Cart\Contract\CartServiceInterface;
use App\Http\Resources\CartResource;


class CartController extends Controller
{
    public function __construct(private CartServiceInterface $cartservice){}

    public function ViewCarts(){
        return CartResource::collection($this->cartservice->ViewCarts());
    }

    public function ViewCart(int $id){
        $cartItem=$this->cartservice->ViewCart($id);

        return new CartResource($cartItem);
    }

    public function CreateCart(array $data){
        return $createdCart=$this->cartservice->CreateCart($data);
    }
}
