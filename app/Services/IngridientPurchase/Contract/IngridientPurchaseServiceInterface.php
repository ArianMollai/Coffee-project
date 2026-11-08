<?php

namespace App\Services\IngridientPurchase\Contract;

use App\Models\IngridientPurchases;
use Illuminate\Support\Collection;

interface IngridientPurchaseServiceInterface
{
    public function ViewIngridientPurchases(): Collection;
    public function ViewIngridientPurchase(int $ingridientPurchaseId): ?IngridientPurchases;
    public function CreateIngridientPurchase(int $ingridientId, array $data): IngridientPurchases;
    public function UpdateIngridientPurchase(int $ingridientPurchaseId, array $data): ?IngridientPurchases;
    public function DeleteIngridientPurchase(int $ingridientPurchaseId);

}
