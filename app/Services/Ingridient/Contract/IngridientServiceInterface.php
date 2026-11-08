<?php

namespace App\Services\Ingridient\Contract;

use Illuminate\Support\Collection;
use App\Models\Ingridient;

interface IngridientServiceInterface
{
    public function ViewIngridients(): Collection;
    public function ViewIngridient(int $id): ?Ingridient;
    public function CreateIngridient(array $data): Ingridient;
    public function UpdateIngridient(int $ingridientId, array $data): ?Ingridient;
    public function DeleteIngridient(int $ingridientId);
}
