<?php

namespace App\Repositories\UnitConversion\Contract;

use Illuminate\Support\Collection;
use App\Models\UnitConversion;

interface UnitConversionRepositoryInterface
{
    public function ViewConversions(): Collection;
    public function ViewConversion(int $id): ?UnitConversion;
    public function FindConversionByUnits(int $fromUnitId, int $toUnitId): ?UnitConversion;
    public function CreateConversion(array $data): UnitConversion;
    public function UpdateConversion(UnitConversion $conversion, array $data): ?UnitConversion;
    public function DeleteConversion(UnitConversion $conversion);
}
