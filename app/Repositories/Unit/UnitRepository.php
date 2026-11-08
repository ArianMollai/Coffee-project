<?php

namespace App\Repositories\Unit;

use Illuminate\Support\Collection;
use App\Models\Unit;
use App\Repositories\Unit\Contract\UnitRepositoryInterface;

class UnitRepository implements UnitRepositoryInterface
{
    public function ViewUnits(): Collection
    {
        return Unit::latest()->get();
    }

    public function ViewUnit(int $id): ?Unit
    {
        return Unit::findOrFail($id);
    }

    public function CreateUnit(array $data): Unit
    {
        return Unit::create($data);
    }

    public function UpdateUnit(Unit $unit, array $data): Unit
    {
        $unit->update($data);

        return $unit;
    }

    public function DeleteUnit(Unit $unit)
    {
        return $unit->delete();
    }
}
