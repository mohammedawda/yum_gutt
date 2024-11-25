<?php

namespace getways\products\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuDetailsResource extends JsonResource
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
            'id'           => $this->id,
            'name'         => $this->name ?? '',
            'category_id'  => $this->name_en ?? '',
            'category'     => $this->category?->name,
            'small_price'  => $this->small_price ?? null,
            'medium_price' => $this->medium_price ?? null,
            'large_price'  => $this->large_price ?? null,
            'discount'     => $this->discount ?? 0,
            'image'        => $this->image,
        ];
    }
}
