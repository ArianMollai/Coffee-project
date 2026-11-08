<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AttributeValueResource;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\PriceIngridientResource;

class PriceResource extends JsonResource
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
            'price' => $this->price,
            'discount' => $this->discount,
            'final_price' => $this->final_price,
            'inventory' => $this->inventory,
            'ingridients' => PriceIngridientResource::collection($this->whenLoaded('Ingridinets')),
            'attribute_values' => AttributeValueResource::collection($this->whenLoaded('AttributeValues'))
        ];
    }
}
