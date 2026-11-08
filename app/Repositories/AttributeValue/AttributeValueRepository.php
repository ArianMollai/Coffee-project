<?php

namespace App\Repositories\AttributeValue;

use App\Models\Attribute;
use Illuminate\Support\Collection;
use App\Models\AttributteValue;
use App\Repositories\AttributeValue\Contract\AttributeValueRepositoryInterface;

class AttributeValueRepository implements AttributeValueRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

/*     public function ViewAttributeValues(Attribute $attribute): Collection
    {
        return Attribute::with('AttributeValues')->get();
    }
*/

    public function ViewAttributeValue(int $id): ?AttributteValue
    {
        return AttributteValue::with('Attribute')->find($id);
    }

    public function CreateAttributeValue(array $data): AttributteValue
    {
        return AttributteValue::create($data);
    }

    public function UpdateAttributeValue(AttributteValue $attributeValue, array $data): AttributteValue
    {
        $attributeValue->update($data);

        return $attributeValue;
    }

    public function DeleteAttributeValue(AttributteValue $attributeValue){
        return $attributeValue->delete();
    }
}
