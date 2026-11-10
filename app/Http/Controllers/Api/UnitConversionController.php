<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UnitConversion\Contract\UnitConversionServiceInterface;
use App\Http\Resources\UnitConversionResource;
use App\Http\Requests\UnitConversion\CreateUnitConversionRequest;
use App\Http\Requests\UnitConversion\UpdateUnitConversionRequest;
use App\Models\Unit;
use App\Policies\UnitPolicy;
use App\Http\Requests\UnitConversion\ViewUnitConversionRequest;

class UnitConversionController extends Controller
{
   public function __construct(private UnitConversionServiceInterface $unitConversionService){}

   public function ViewUnitConversions(){
      $this->authorize('viewAny', Unit::class);

      return UnitConversionResource::collection($this->unitConversionService->ViewConversions());
   }

   public function ViewConversion(int $id){
      $this->authorize('view', Unit::class);

      return new UnitConversionResource($this->unitConversionService->ViewConversion($id));
   }

   public function ViewConversionByUnits(ViewUnitConversionRequest $request){
      $this->authorize('view', Unit::class);

      $requestValidated=$request->validated();

      $fromUnitId=$requestValidated['from_unit_id'];
      $toUnitId=$requestValidated['to_unit_id'];

      return new UnitConversionResource($this->unitConversionService->FindConversionByUnits($fromUnitId, $toUnitId));
   }

   public function CreateConversion(CreateUnitConversionRequest $request){
      $this->authorize('create', Unit::class);

      return new UnitConversionResource($this->unitConversionService->CreateConversion($request->validated()));
   }

   public function UpdateConversion(UpdateUnitConversionRequest $request, int $id){
      $this->authorize('update', Unit::class); 

      return new UnitConversionResource($this->unitConversionService->UpdateConversion($id, $request->validated()));
   }

   public function DeleteUnitConversion(int $id){
      $this->authorize('delete', Unit::class);

      $this->unitConversionService->DeleteConversion($id);

      return response()->json([
         'message' => 'Unit conversion deleted'
      ]);
   }
   
   
}
