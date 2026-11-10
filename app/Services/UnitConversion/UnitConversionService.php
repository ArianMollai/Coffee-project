<?php

namespace App\Services\UnitConversion;

use App\Repositories\UnitConversion\Contract\UnitConversionRepositoryInterface;
use App\Models\UnitConversion;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\UnitConversion\Contract\UnitConversionServiceInterface;

class UnitConversionService implements UnitConversionServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private UnitConversionRepositoryInterface $UnitConversionRepository)
    {}

    public function ViewConversions(): Collection
    {
        return $this->UnitConversionRepository->ViewConversions();
    }

    public function ViewConversion(int $id): ?UnitConversion
    {
        return $this->UnitConversionRepository->ViewConversion($id) ?? throw new ModelNotFoundException("Conversion not found"); 
    }

    public function FindConversionByUnits(int $fromUnit, int $toUnit): ?UnitConversion
    {
        $direct=$this->UnitConversionRepository->FindConversionByUnits($fromUnit, $toUnit);
        if($direct){
            return $direct;
        }
        
        $reverse=$this->UnitConversionRepository->FindConversionByUnits($toUnit, $fromUnit);

        return $reverse ?? throw new ModelNotFoundException("Conversion not found");  
    }

    public function CreateConversion(array $data): UnitConversion
    {
        return $this->UnitConversionRepository->CreateConversion($data);
    }

    public function UpdateConversion(int $id, array $data): ?UnitConversion
    {
        $unitConversion=$this->ViewConversion($id) ?? throw new ModelNotFoundException("Conversion not found");

        return $this->UnitConversionRepository->UpdateConversion($unitConversion, $data);
    }

    public function DeleteConversion(int $id)
    {
        $conversion=$this->ViewConversion($id) ?? throw new ModelNotFoundException("Conversion not found"); 

        return $this->UnitConversionRepository->DeleteConversion($conversion);
    }

    public function Convert(float $quantity, int $fromUnitId, int $toUnitId): float
    {
        if($fromUnitId === $toUnitId){
            return $quantity;
        }

        $conversion=$this->FindConversionByUnits($fromUnitId, $toUnitId);
        if($conversion){
            return $quantity * $conversion->multiplier;
        }

        $reverse=$this->FindConversionByUnits($toUnitId, $fromUnitId);
        if($reverse){
            return $quantity / $reverse->multiplier;
        }

        throw new ModelNotFoundException("No Conversion founded");
    }
}
