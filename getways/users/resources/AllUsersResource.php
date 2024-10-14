<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllUsersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'full_phone'            => $this->full_phone,
            'phone'                 => $this->phone,
            'nationalId_photo_type' => $this->nationalId_photo_type,
            'national_id'           => $this->national_id,
            'national_id_photo'     => $this->national_id_photo_url,
            'country_code'          => $this->country_code,
            'role_id'               => $this->role_id,
            'city'                  => !is_null($this->city) ? new CityResource($this->city) : [],
            'country'               => !is_null($this->country) ? new CountryResource($this->country) : [],
            'wallet'                => $this->wallet,
            'created_at'            => $this->created_at->toFormattedDateString(),
            'status'                => $this->status ?? '0',
            'block'                 => $this->block ?? '0',
            'block_reason'          => $this->block_reason,
        ];
    }
}
