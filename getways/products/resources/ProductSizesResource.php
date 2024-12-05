<?php

namespace getways\products\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSizesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    */
    public function toArray(Request $request): array
    {
        return [
            'id'           => (int)$this->id,
            'name'         => $this->name,
            'price'         => $this->pivot?->price,
        ];
    }
}
