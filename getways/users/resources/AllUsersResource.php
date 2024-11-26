<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllUsersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'full_phone'    => $this->full_phone,
            'profile_photo' => $this->profile_photo,
            'role_id'       => $this->role_id,
            'orders'        => $this->orders_count ?? 0,
            'reels'         => $this->reels_count ?? 0,
            'city'          => !is_null($this->city) ? new CityResource($this->city) : [],
            'country'       => !is_null($this->country) ? new CountryResource($this->country) : [],
            'join_date'     => $this->created_at,
            # TODO::set cashback to 0 until handling it
            'cashback'      => 0,
        ];
    }
}
