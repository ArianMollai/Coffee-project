<?php

namespace App\Services\IngridientPurchase;

use App\Repositories\IngridientPurchas\Contract\IngridientPurchaseInterface;
use App\Models\IngridientPurchases;
use Illuminate\Support\Collection;
use App\Models\Ingridient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Ingridient\Contract\IngridientServiceInterface;
use App\Services\UnitConversion\Contract\UnitConversionServiceInterface;
use App\Repositories\Ingridient\Contract\IngridientRepositoryInterface;
use App\Services\IngridientPurchase\Contract\IngridientPurchaseServiceInterface;



class IngridientPurchaseService implements IngridientPurchaseServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private IngridientPurchaseInterface $ingridientPurchaseRepository,
        private IngridientServiceInterface $ingridientService,
        private UnitConversionServiceInterface $unitConversionService,
        private IngridientRepositoryInterface $ingridientRepository
        )
    {}

    public function ViewIngridientPurchases(): Collection
    {
        return $this->ingridientPurchaseRepository->ViewIngridientPurchases();
    }

    public function ViewIngridientPurchase(int $ingridientPurchaseId): ?IngridientPurchases
    {
        return $this->ingridientPurchaseRepository->ViewIngridientPurchase($ingridientPurchaseId) ?? throw new ModelNotFoundException("No ingridient purchases found");
    }

    public function CreateIngridientPurchase(int $ingridientId, array $data): IngridientPurchases
    {
        $ingridient=$this->ingridientService->ViewIngridient($ingridientId) ?? throw new ModelNotFoundException("No ingridient Found");

        $convert=$this->unitConversionService->Convert($data['quantity'], $data['unit_id'], $ingridient->base_unit_id);

        $this->ingridientRepository->IncrementQuantity($ingridient, $convert);

        return $this->ingridientPurchaseRepository->CreateIngridientPurchase([
            'ingridient_id' => $ingridient->id,
            'unit_id' => $data['unit_id'],
            'quantity' => $data['quantity']
        ]);
    }

    public function UpdateIngridientPurchase(int $ingridientPurchaseId, array $data): ?IngridientPurchases
    {
        $ingridientPurchase=$this->ViewIngridientPurchase($ingridientPurchaseId) ?? throw new ModelNotFoundException("No ingridient purchase Found");

        $ingridientPurchase->ingridientPurchaseRepository($data);

        return $ingridientPurchase;
    }

    public function DeleteIngridientPurchase(int $ingridientPurchaseId)
    {
        $ingridientPurchase=$this->ViewIngridientPurchase($ingridientPurchaseId) ?? throw new ModelNotFoundException("No ingridient Found");

        $this->ingridientPurchaseRepository->DeleteIngridientPurchase($ingridientPurchase);
    }
}
