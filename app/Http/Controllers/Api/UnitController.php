<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Services\Unit\Contract\UnitServiceInterface;
use App\Http\Resources\UnitResource;
use App\Http\Requests\Unit\CreateUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Policies\UnitPolicy;


class UnitController extends Controller
{
    public function __construct(private UnitServiceInterface $unitService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Unit::class);

        return UnitResource::collection($this->unitService->ViewUnits());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUnitRequest $request)
    {
        $this->authorize('create', Unit::class);

        $validated=$request->validated();

        return new UnitResource($this->unitService->CreateUnit($validated));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $this->authorize('view', Unit::class);

        return new UnitResource($this->unitService->ViewUnit($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $unitId, UpdateUnitRequest $request)
    {
        $this->authorize('update', Unit::class);

        $validated=$request->validated();

        return new UnitResource($this->unitService->UpdateUnit($unitId, $validated));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->authorize('delete', Unit::class);

        $this->unitService->DeleteUnit($id);

        return response()->json([
            'message' => 'Unit deleted successfully'
        ]);
    }
}
