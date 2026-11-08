<?php

namespace App\Repositories\Ingridient;

use Illuminate\Support\Collection;
use App\Models\Ingridient;
use App\Models\IngridientPurchases;
use App\Repositories\Ingridient\Contract\IngridientRepositoryInterface;

class IngridientRepository implements IngridientRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    public function ViewIngridients(): Collection
    {
        return Ingridient::with('Unit')->get();
    }

    public function ViewIngridient(int $id): ?Ingridient
    {
        return Ingridient::with('Unit')->findOrFail($id);
    }

    public function CreateIngridient(array $data): Ingridient
    {
        $ingridient=Ingridient::create($data);

        return $ingridient->load('Unit');
    }

    public function UpdateIngridient(Ingridient $ingridient, array $data): Ingridient
    {
        $ingridient->update($data);

        return $ingridient->load('Unit');
    }

    public function DeleteIngridient(Ingridient $ingridient){
        return $ingridient->delete();
    }

    public function IncrementQuantity(Ingridient $ingridient, float $amount): void
    {
        $ingridient->increment('quantity', $amount);
    }

    public function DecrementQuantity(Ingridient $ingridient, float $amount): void
    {
        $ingridient->decrement('quantity', $amount);
    }
}
