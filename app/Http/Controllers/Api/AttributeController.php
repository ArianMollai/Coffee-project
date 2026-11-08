<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Services\Attribute\Contract\AttributeServiceInterface;
use App\Http\Resources\AttributeResource;
use App\Http\Requests\Attribute\CreateAttributeRequest;
use App\Http\Requests\Attribute\updateAttributeRequest;
use App\Policies\AttributePolicy;

class AttributeController extends Controller
{
    public function __construct(private AttributeServiceInterface $attributeService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Attribute::class);

        return AttributeResource::collection($this->attributeService->ViewAttributes());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAttributeRequest $request)
    {
        $this->authorize('create', Attribute::class);    

        $validated=$request->validated();

        return new AttributeResource($this->attributeService->CreateAttribute($validated));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $this->authorize('view', Attribute::class);

        return new AttributeResource($this->attributeService->ViewAttribute($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, updateAttributeRequest $request)
    {
        $this->authorize('update', Attribute::class);

        $validate=$request->validated();

        return new AttributeResource($this->attributeService->UpdateAttribute($id, $validate));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->authorize('delete', Attribute::class);

        $this->attributeService->DeleteAttribute($id);

        return response()->json([
            'message' => 'Attribute deleted successfully'
        ]);
    }
}
