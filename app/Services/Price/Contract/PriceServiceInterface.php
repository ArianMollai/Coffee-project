<?php

namespace App\Services\Price\Contract;

use App\Models\Price;

interface PriceServiceInterface
{
    public function CreatePrice(array $data): Price;
    public function ViewPrice(int $id): ?Price;
    public function UpdatePrice(int $id, array $data): ?Price;
    public function SyncIngridients(Price $price, array $ingridients);
    public function DeletePrice(int $id);
}