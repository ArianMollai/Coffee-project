<?php

namespace App\Repositories\AttributeValue\Contract;

use App\Models\Attribute;
use App\Models\AttributteValue;

interface AttributeValueRepositoryInterface
{
    public function ViewAttributeValue(int $id): ?AttributteValue;
    public function CreateAttributeValue(array $data): AttributteValue;
    public function UpdateAttributeValue(AttributteValue $attributeValue, array $data): AttributteValue;
    public function DeleteAttributeValue(AttributteValue $attributeValue);
}
