<?php

namespace App\Services\Ingridient;

use App\Repositories\Ingridient\Contract\IngridientRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Ingridient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Ingridient\Contract\IngridientServiceInterface;


class IngridientService implements IngridientServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private IngridientRepositoryInterface $ingridientRepository)
    {}

    public function ViewIngridients(): Collection
    {
        return $this->ingridientRepository->ViewIngridients();
    }

    public function ViewIngridient(int $id): ?Ingridient
    {
        return $this->ingridientRepository->ViewIngridient($id) ?? throw new ModelNotFoundException("No Ingridient Found");
    }

    public function CreateIngridient(array $data): Ingridient
    {
        return $this->ingridientRepository->CreateIngridient($data) ?? throw new Exception("Couldnt create Ingridient");
    }

    public function UpdateIngridient(int $ingridientId, array $data): ?Ingridient
    {
        $ingridient=$this->ViewIngridient($ingridientId) ?? throw new ModelNotFoundException("No Ingridient Found");
        
        $this->ingridientRepository->UpdateIngridient($ingridient, $data) ?? throw new Exception("Couldnt create Ingridient");
        
        return $ingridient;
    }

    public function DeleteIngridient(int $ingridientId)
    {
        $ingridient=$this->ViewIngridient($ingridientId);

        return $this->ingridientRepository->DeleteIngridient($ingridient);
    }
}
