<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UnitResource;

class IngridientsResource extends JsonResource
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
           'base_unit' => new UnitResource($this->whenLoaded('Unit')),
           'quantity' => $this->quantity,
           'low_stock_treshhold' => $this->low_stock_treshhold
        ];
    }
}
