<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\IngridientPurchase\Contract\IngridientPurchaseServiceInterface;
use App\Http\Resources\IngridientPurchaseResource;
use App\Http\Requests\IngridientPurchase\CreateIngridientPurchaseRequest;
use App\Models\Ingridient;
use App\Policies\IngridientPolicy;


class IngridientPurchaseController extends Controller
{
    public function __construct(private IngridientPurchaseServiceInterface $ingridientPurchaseService){}

    public function ViewIngridientPurchases(){
        $this->authorize('viewAny', Ingridient::class);

        return IngridientPurchaseResource::collection($this->ingridientPurchaseService->ViewIngridientPurchases());
    }

    public function ViewIngridientPurchase(int $ingridientPurchaseId){
        $this->authorize('view', Ingridient::class);

        return new IngridientPurchaseResource($this->ingridientPurchaseService->ViewIngridientPurchase($ingridientPurchaseId));
    }

    public function CreateIngridientPurchase(int $ingridientId, CreateIngridientPurchaseRequest $request)
    {
        $this->authorize('create', Ingridient::class);

        return new IngridientPurchaseResource($this->ingridientPurchaseService->CreateIngridientPurchase($ingridientId, $request->validated()));
    }

    public function UpdateIngridientPurchase(int $ingridientPurchaseId, CreateIngridientPurchaseRequest $request)
    {
        $this->authorize('update', Ingridient::class);

        return new IngridientPurchaseResource($this->ingridientPurchaseService->UpdateIngridientPurchase($ingridientPurchaseId, $request->validated()));
    }

    public function DeleteIngridientPurchase(int $ingridientPurchaseId){
        $this->authorize('delete', Ingridient::class);

        $this->ingridientPurchaseService->DeleteIngridientPurchase($ingridientPurchaseId);

        return response()->json([
            'message' => 'Ingridient purchase deleted'
        ]);
    }
}