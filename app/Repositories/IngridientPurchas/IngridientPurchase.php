<?php

namespace App\Repositories\IngridientPurchas;

use App\Models\IngridientPurchases;
use Illuminate\Support\Collection;
use App\Repositories\IngridientPurchas\Contract\IngridientPurchaseInterface;

class IngridientPurchase implements IngridientPurchaseInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function ViewIngridientPurchases(): Collection
    {
        return IngridientPurchases::with('Ingridient')->latest()->get();
    }

    public function ViewIngridientPurchase(int $ingridientPurchaseId): ?IngridientPurchases
    {
        return IngridientPurchases::with('Ingridient')->find($ingridientPurchaseId);
    }

    public function CreateIngridientPurchase(array $data): IngridientPurchases
    {
        $ingridientPurchase=IngridientPurchases::create($data);

        return $ingridientPurchase->load('Ingridient')->load('Unit');
    }

    public function UpdateIngridientPurchase(IngridientPurchases $ingridientPurchase, array $data): IngridientPurchases
    {
        $ingridientPurchase->update($data);

        return $ingridientPurchase->load('Ingridient')->load('Unit');
    }

    public function DeleteIngridientPurchase(IngridientPurchases $ingridientPurchase)
    {
        return $ingridientPurchase->delete();
    }
}
