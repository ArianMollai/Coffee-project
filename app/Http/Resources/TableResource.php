<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PriceResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "number" => $this->number,
            'capacity' => $this->capacity,
            'place' => $this->place,
            'status' => $this->status,
            'is_vip' => $this->is_vip,
            'price' =>new PriceResource($this->whenLoaded('Prices'))
        ];
    }
}
