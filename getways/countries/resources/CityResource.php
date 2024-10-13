<?php

namespace getways\cores\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name_ar'              => $this->name_ar,
            'name_en'              => $this->name_en,
            'delivery_cost'     => $this->delivery_cost,
        ];
    }
}
