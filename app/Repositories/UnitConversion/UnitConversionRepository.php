<?php

namespace App\Repositories\UnitConversion;

use Illuminate\Support\Collection;
use App\Models\UnitConversion;
use App\Repositories\UnitConversion\Contract\UnitConversionRepositoryInterface;

class UnitConversionRepository implements UnitConversionRepositoryInterface
{
    public function ViewConversions(): Collection
    {
        return UnitConversion::with('ToUnit')->with('FromUnit')->latest()->get();
    }

    public function ViewConversion(int $id): ?UnitConversion
    {
        return UnitConversion::with('ToUnit')->with('FromUnit')->findOrFail($id);
    }

    public function FindConversionByUnits(int $fromUnitId, int $toUnitId): ?UnitConversion
    {
        return UnitConversion::with('ToUnit')->with('FromUnit')->where('from_unit_id', $fromUnitId)->where('to_unit_id', $toUnitId)->first();
    }

    public function CreateConversion(array $data): UnitConversion
    {
        $unitConversion=UnitConversion::create($data);

        return $unitConversion->load('ToUnit')->load('FromUnit');
    }

    public function UpdateConversion(UnitConversion $conversion, array $data): ?UnitConversion
    {
        $conversion->update($data);

        return $conversion;
    }

    public function DeleteConversion(UnitConversion $conversion)
    {
        return $conversion->delete();
    }
}
