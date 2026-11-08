<?php

namespace App\Repositories\Unit\Contract;

use Illuminate\Support\Collection;
use App\Models\Unit;

interface UnitRepositoryInterface
{
    public function ViewUnits(): Collection;
    public function ViewUnit(int $id): ?Unit;
    public function CreateUnit(array $data): Unit;
    public function UpdateUnit(Unit $unit, array $data): Unit;
    public function DeleteUnit(Unit $unit);
}
