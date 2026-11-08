<?php

namespace App\Repositories\Price;

use Illuminate\Support\Collection;
use App\Models\Price;
use App\Repositories\Price\Contract\PriceRepositoryInterface;


class PriceRepository implements PriceRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function ViewPrice(int $id): ?Price
    {
        return Price::findOrFail($id);
    }

    public function CreatePrice(array $data): ?Price
    {
        return Price::create($data);
    }

    public function UpdatePrice(Price $price, array $data): ?Price
    {
        $price->update($data);

        return $price;
    }

    public function DeletePrice(Price $price){
        return $price->delete();
    }
    
}
