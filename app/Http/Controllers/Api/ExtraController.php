<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Extra\Contract\ExtraServiceInterface;
use App\Http\Resources\ExtraResource;
use App\Http\Requests\Extra\CreateExtraRequest;
use App\Http\Requests\Extra\UpdateExtraRequest;
use App\Models\Product;
use App\Policies\ProductPolicy;

class ExtraController extends Controller
{
    public function __construct(private ExtraServiceInterface $extraService){}
    
    public function ViewExtras(){
        $this->authorize('viewAny', Product::class);

        return ExtraResource::collection($this->extraService->ViewExtras());
    }

    public function ViewExtra(int $extraId){
        $this->authorize('view', Product::class);

        return new ExtraResource($this->extraService->ViewExtra($extraId));
    }

    public function CreateExtra(CreateExtraRequest $request){
        $this->authorize('create', Product::class);

        return new ExtraResource($this->extraService->CreateExtra($request->validated()));
    }

    public function UpdateExtra(int $extraId, UpdateExtraRequest $request){
        $this->authorize('update', Product::class);

        return new ExtraResource($this->extraService->UpdateExtra($extraId, $request->validated()));
    }

    public function DeleteExtra(int $extraId){
        $this->authorize('delete', Product::class);

        $this->extraService->DeleteExtra($extraId);

        return response()->json([
            'message' => 'Extra Deleted successfully'
        ]);
    }
}
