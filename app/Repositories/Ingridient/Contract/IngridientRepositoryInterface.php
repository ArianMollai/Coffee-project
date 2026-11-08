<?php

namespace App\Repositories\Ingridient\Contract;

use Illuminate\Support\Collection;
use App\Models\Ingridient;

interface IngridientRepositoryInterface
{
    public function ViewIngridients(): Collection;
    public function ViewIngridient(int $id): ?Ingridient;
    public function CreateIngridient(array $data): Ingridient;
    public function UpdateIngridient(Ingridient $ingridient, array $data): Ingridient;
    public function DeleteIngridient(Ingridient $ingridient);
    public function IncrementQuantity(Ingridient $ingridient, float $amount): void;
    public function DecrementQuantity(Ingridient $ingridient, float $amount): void;
}
