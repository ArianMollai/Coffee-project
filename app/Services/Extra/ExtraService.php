<?php

namespace App\Services\Extra;

use App\Repositories\Extra\Contract\ExtraRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Extra;
use App\Services\Extra\Contract\ExtraServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ExtraService implements ExtraServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ExtraRepositoryInterface $extraRepository)
    {}

    public function ViewExtras(): Collection
    {
        return $this->extraRepository->ViewExtras();
    }

    public function ViewExtra(int $extraId): ?Extra
    {
        return $this->extraRepository->ViewExtra($extraId) ?? throw new ModelNotFoundException("No Extra found");
    }

    public function CreateExtra(array $data): Extra
    {
        $extra =$this->extraRepository->CreateExtra($data) ?? throw new Exception("couldnt create extra");

        $this->SyncProducts($extra, $data['product_id']);

        return $extra;
    }

    public function UpdateExtra(int $extraId, array $data): ?Extra
    {
        $extra=$this->ViewExtra($extraId) ?? throw new ModelNotFoundException("No Extra found");

        if(isset($data['product_id'])){
            $this->$this->SyncProducts($extra, $data['product_id']);
        }
        
        return $this->extraRepository->UpdateExtra($extra, $data);
    }

    public function DeleteExtra(int $extraId)
    {
        $extra=$this->ViewExtra($extraId);

        return $this->extraRepository->DeleteExtra($extra);
    }

    public function SyncProducts(Extra $extra, array $productsIds){
        return $this->extraRepository->SyncProducts($extra, $productsIds);
    }
}
