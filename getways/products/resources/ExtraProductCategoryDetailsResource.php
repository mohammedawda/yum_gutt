<?php

namespace getways\products\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExtraProductCategoryDetailsResource extends JsonResource
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
            'id'            => (int)$this->id,
            'category_name' => $this->category_name,
            'is_require'    => (boolean)$this->is_require,
            'extra_product' => ExtraProductResource::collection($this->extraProducts),
        ];
    }
}
