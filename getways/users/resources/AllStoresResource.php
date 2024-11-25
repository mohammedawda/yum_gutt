<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllStoresResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'full_phone'            => $this->full_phone,
            'nationalId_photo_type' => $this->nationalId_photo_type,
            'national_id'           => $this->national_id,
            'national_id_photo'     => $this->national_id_photo_url,
            'role_id'               => $this->role_id,
            'orders'                => $this->store?->orders->count(),
            'store_reels'           => $this->store?->orders->count(),
            'reels'                 => $this->store?->reels->count(),
            'city'                  => !is_null($this->city) ? new CityResource($this->city) : [],
            'country'               => !is_null($this->country) ? new CountryResource($this->country) : [],
            # TODO::set cashback to 0 until handling it
            'cashback'              => 0,
            'created_at'            => $this->created_at->toFormattedDateString(),
            'status'                => $this->status ?? '0',
            'block'                 => $this->block ?? '0',
            'block_reason'          => $this->block_reason,
        ];
    }
}
