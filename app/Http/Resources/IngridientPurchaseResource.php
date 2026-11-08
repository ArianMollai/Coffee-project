<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\IngridientsResource;
use App\Http\Resources\UnitResource;


class IngridientPurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ingridient' => new IngridientsResource($this->whenLoaded('Ingridient')),
            'unit' => new UnitResource($this->whenLoaded('Unit')),
            'quantity' => $this->quantity
        ];
    }
}
