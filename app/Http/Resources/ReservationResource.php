<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\TableResource;

class ReservationResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('User')),
            'table' => new TableResource($this->whenLoaded('Table')),
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'payment_expires_at' => $this->payment_expires_at,
            'status' => $this->status,
            'price' => $this->price
        ];
    }
}
