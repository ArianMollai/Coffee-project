<?php

namespace App\Repositories\IngridientPurchas\Contract;

use App\Models\IngridientPurchases;
use Illuminate\Support\Collection;

interface IngridientPurchaseInterface
{
    public function ViewIngridientPurchases(): Collection;
    public function ViewIngridientPurchase(int $ingridientPurchaseId): ?IngridientPurchases;
    public function CreateIngridientPurchase(array $data): IngridientPurchases;
    public function UpdateIngridientPurchase(IngridientPurchases $ingridientPurchase, array $data): IngridientPurchases;
    public function DeleteIngridientPurchase(IngridientPurchases $ingridientPurchase);
}
