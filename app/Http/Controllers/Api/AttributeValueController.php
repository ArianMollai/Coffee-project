<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AttributeValue\Contract\AttributeValueServiceInterface;
use App\Http\Resources\AttributeValueResource;
use App\Http\Requests\AttributeValue\CreateAttributeValueRequest;
use App\Http\Requests\AttributeValue\UpdateAttributeValueRequest;
use App\Models\Attribute;

class AttributeValueController extends Controller
{
    public function __construct(private AttributeValueServiceInterface $attributeValueService){}

    public function ViewAttributeValue(int $id)
    {
        $this->authorize('view', Attribute::class);

        return new AttributeValueResource($this->attributeValueService->ViewAttributeValue($id));
    }

    public function CreateAttributeValue(CreateAttributeValueRequest $request)
    {
        $this->authorize('create', Attribute::class);

        $validated=$request->validated();

        return new AttributeValueResource($this->attributeValueService->CreateAttributeValue($validated));
    }

    public function UpdatedAttributeValue(UpdateAttributeValueRequest $request, int $attributeId, int $attributeValueId)
    {
        $this->authorize('update', Attribute::class);

        $validated=$request->validated();

        return new AttributeValueResource($this->attributeValueService->UpdateAttributeValue($validated, $attributeId, $attributeValueId));
    }

    public function DeleteAttributeValue(int $attributeValueId){
        $this->authorize('delete', Attribute::class);

        $this->attributeValueService->DeleteAttributeValue($attributeValueId);

        return response()->json([
            'attribute value' => 'Deleted successfully'
        ]);
    }
}
