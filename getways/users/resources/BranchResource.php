<?php

namespace getways\users\resources;

use getways\settings\resources\CityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'address'       => $this->address,
            'phone'         => $this->phone,
            'lat'           => $this->lat,
            'lng'           => $this->lng,
            'status'        => $this->status,
            'working_time'  => $this->working_time,
            'city'          => new CityResource ($this->city),

        ];
    }
}
