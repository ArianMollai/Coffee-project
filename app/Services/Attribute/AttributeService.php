<?php

namespace App\Services\Attribute;

use Illuminate\Support\Collection;
use App\Repositories\Attribute\Contracts\AttributeRepositoryInterface;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Attribute\Contract\AttributeServiceInterface;
use App\Services\AttributeValue\Contract\AttributeValueServiceInterface;

class AttributeService implements AttributeServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private AttributeRepositoryInterface $attributeRepository,
    )
    {
        //
    }

    public function ViewAttributes(): Collection
    {
        return $this->attributeRepository->ViewAttributes();
    }

    public function ViewAttribute(int $id): ?Attribute
    {
        return $this->attributeRepository->ViewAttribute($id) ?? throw new ModelNotFoundException("Attribute not found");
    }

    public function CreateAttribute(array $data): Attribute
    {
        $attribute=$this->attributeRepository->CreateAttribute($data);

        return $attribute->load('AttributeValues');
    }

    public function UpdateAttribute(int $id, array $data): ?Attribute
    {
        $attribute=$this->attributeRepository->ViewAttribute($id) ?? throw new ModelNotFoundException("Attribute not found");

        $this->attributeRepository->UpdateAttribute($attribute, $data);

        return $attribute->load('AttributeValues');
    }

    public function DeleteAttribute(int $id)
    {
        $attribute=$this->attributeRepository->ViewAttribute($id) ?? throw new ModelNotFoundException("Attribute not found");

        $this->attributeRepository->DeleteAttribute($attribute);
    }
}
