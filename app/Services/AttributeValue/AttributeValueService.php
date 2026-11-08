<?php

namespace App\Services\AttributeValue;

use App\Repositories\AttributeValue\Contract\AttributeValueRepositoryInterface;
use App\Models\AttributteValue;
use App\Models\Attribute;
use App\Models\Price;
use App\Services\Attribute\Contract\AttributeServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\AttributeValue\Contract\AttributeValueServiceInterface;

class AttributeValueService implements AttributeValueServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private AttributeValueRepositoryInterface $attributeValueRepository,
        private AttributeServiceInterface $attributeService
    )
    {}

    public function ViewAttributeValue(int $id): ?AttributteValue
    {
        return $this->attributeValueRepository->ViewAttributeValue($id) ?? throw new ModelNotFoundException("Attribute value not found");
    }

    // چون توی متد post از params پشتیبانی نمیشه attribute_id رو توی body میذاریم
    public function CreateAttributeValue(array $data): AttributteValue
    {
        $attribute=$this->attributeService->ViewAttribute($data['attribute_id']) ?? throw new ModelNotFoundException("Attribute not found");

        if(isset($attribute->is_color) && $attribute->is_color === true && !isset($data['color_code'])){
            throw new Exception("Color code field should be filled out");
        }

        return $this->attributeValueRepository->CreateAttributeValue([
            'attribute_id' => $attribute->id,
            'value' => $data['value'],
            'color_code' => $data['color_code'] ?? null
        ]);
    }

    public function UpdateAttributeValue(array $data, int $attributeId, int $attributeValueId): ?AttributteValue
    {
        $attribute=$this->attributeService->ViewAttribute($attributeId) ?? throw new ModelNotFoundException("Attribute not found");

        $attributeValue=$this->ViewAttributeValue($attributeValueId) ?? throw new ModelNotFoundException("Attribute value not found");
        if($attributeValue->attribute_id !== $attribute->id){
            throw new ModelNotFoundException("This value does not belong to the specified attribute.");
        }

        return $this->attributeValueRepository->UpdateAttributeValue($attributeValue, [
            'attribute_id' => $attribute->id,
            'value' => $data['value'],
            'color_code' => $data['color_code'] ?? null
        ]);
    }

    public function DeleteAttributeValue(int $id)
    {
        $attributeValue=$this->ViewAttributeValue($id) ?? throw new ModelNotFoundException("Attribute value not found");

        return $this->attributeValueRepository->DeleteAttributeValue($attributeValue);
    }

    public function SyncPrices(Price $price, array $attributeValueIds)
    {
        return $price->AttributeValues()->sync($attributeValueIds);
    }
}
