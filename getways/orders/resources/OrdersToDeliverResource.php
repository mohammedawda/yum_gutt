<?php

namespace getways\orders\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersToDeliverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'delivery_status' => $this->delivery_status ?? 0,
            'cart'            => CartDetailsResource::collection($this->cart),
            'created_at'      => $this->created_at,
        ];
    }
}
