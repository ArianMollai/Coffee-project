<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ingridient\Contract\IngridientServiceInterface;
use App\Http\Resources\IngridientsResource;
use App\Http\Requests\Ingridient\CreateIngridientRequest;
use App\Http\Requests\Ingridient\UpdateIngridientRequest;
use App\Policies\IngridientPolicy;
use App\Models\Ingridient;


class IngridientController extends Controller
{
    public function __construct(private IngridientServiceInterface $ingridientService){}

    public function ViewIngridients(){
        $this->authorize('viewAny', Ingridient::class);

        return IngridientsResource::collection($this->ingridientService->ViewIngridients());
    }

    public function ViewIngridient(int $ingridientId){
        $this->authorize('view', Ingridient::class);

        return new IngridientsResource($this->ingridientService->ViewIngridient());
    }

    public function CreateIngridient(CreateIngridientRequest $request){
        $this->authorize('create', Ingridient::class);

        return new IngridientsResource($this->ingridientService->CreateIngridient($request->validated()));
    }

    public function UpdateIngridient(int $ingridientId, UpdateIngridientRequest $request){
        $this->authorize('update', Ingridient::class);

        return new IngridientsResource($this->ingridientService->UpdateIngridient($ingridientId, $request->validated()));
    }

    public function DeleteIngridient(int $ingridientId){
        $this->authorize('delete', Ingridient::class);

        $this->ingridientService->DeleteIngridient($ingridientId);

        return response()->json([
            'messsage' => 'Ingridient deleted successfully'
        ]);
    }
}
