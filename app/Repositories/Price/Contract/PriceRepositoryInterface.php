<?php

namespace App\Repositories\Price\Contract;

use App\Models\Price;

interface PriceRepositoryInterface
{
    public function ViewPrice(int $id): ?Price;
    public function CreatePrice(array $data): ?Price;
    public function UpdatePrice(Price $price, array $data): ?Price;
    public function DeletePrice(Price $price);
}