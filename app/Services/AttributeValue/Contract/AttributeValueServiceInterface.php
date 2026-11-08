<?php

namespace App\Services\AttributeValue\Contract;

use App\Models\AttributteValue;
use App\Models\Price;

interface AttributeValueServiceInterface
{
    public function ViewAttributeValue(int $id): ?AttributteValue;
    public function CreateAttributeValue(array $data): AttributteValue;
    public function UpdateAttributeValue(array $data, int $attributeId, int $attributeValueId): ?AttributteValue;
    public function DeleteAttributeValue(int $id);
    public function SyncPrices(Price $price, array $attributeValueIds);
}