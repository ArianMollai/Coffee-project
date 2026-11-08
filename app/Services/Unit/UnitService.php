<?php

namespace App\Services\Unit;

use App\Repositories\Unit\Contract\UnitRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use App\Models\Unit;
use App\Services\Unit\Contract\UnitServiceInterface;

class UnitService implements UnitServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private UnitRepositoryInterface $unitRepository)
    {}

    public function ViewUnits(): Collection
    {
        return $this->unitRepository->ViewUnits();
    }

    public function ViewUnit(int $id): ?Unit
    {
        return $this->unitRepository->ViewUnit($id) ?? throw new ModelNotFoundException("Unit not found");
    }

    public function CreateUnit(array $data): Unit
    {
        return $this->unitRepository->CreateUnit($data);
    }

    public function UpdateUnit(int $id, array $data): ?Unit
    {
        $unit=$this->ViewUnit($id) ?? throw new ModelNotFoundException("Unit not found");

        $this->unitRepository->UpdateUnit($unit, $data);

        return $unit;
    }

    public function DeleteUnit(int $id)
    {
        $unit=$this->ViewUnit($id) ?? throw new ModelNotFoundException("Unit not found");

        return $this->unitRepository->DeleteUnit($unit);
    }
}
