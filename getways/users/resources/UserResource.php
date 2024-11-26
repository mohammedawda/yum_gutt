<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'full_phone'            => $this->full_phone,
            'phone'                 => $this->phone,
            'country_code'          => $this->country_code,
            'role_id'               => $this->role_id,
            'city'                  => !is_null($this->city) ? new CityResource($this->city) : [],
            'country'               => !is_null($this->country) ? new CountryResource($this->country) : [],
            'store'                 => $this->store ? new StoreDataResource($this->store) : null,
            'wallet'                => $this->wallet,
            'fcm'                   => $this->fcm,
            'created_at'            => $this->created_at,
            'status'                => $this->status ?? '0',
            'block'                 => $this->block ?? '0',
            'block_reason'          => $this->block_reason,
            'action'                => new ActionResource($this),
        ];
    }
}
