<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'lat'            => $this->lat,
            'lng'            => $this->lng,
            'name'           => $this->name,
            'city_id'        => new CityResource($this->city),
            'branch_id'      => new BranchResource($this->branch),
        ];
    }
}
