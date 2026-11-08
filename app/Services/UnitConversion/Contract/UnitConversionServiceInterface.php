<?php

namespace App\Services\UnitConversion\Contract;

use App\Models\UnitConversion;
use Illuminate\Support\Collection;

interface UnitConversionServiceInterface
{
    public function ViewConversions(): Collection;
    public function ViewConversion(int $id): ?UnitConversion;
    public function FindConversionByUnits(int $fromUnit, int $toUnit): ?UnitConversion;
    public function CreateConversion(array $data): UnitConversion;
    public function UpdateConversion(int $id, array $data): ?UnitConversion;
    public function DeleteConversion(int $id);
    public function Convert(float $quantity, int $fromUnitId, int $toUnitId): float;
}
