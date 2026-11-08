<?php

namespace App\Services\Unit\Contract;

use Illuminate\Support\Collection;
use App\Models\Unit;

interface UnitServiceInterface
{
    public function ViewUnits(): Collection;
    public function ViewUnit(int $id): ?Unit;
    public function CreateUnit(array $data): Unit;
    public function UpdateUnit(int $id, array $data): ?Unit;
    public function DeleteUnit(int $id);
}
