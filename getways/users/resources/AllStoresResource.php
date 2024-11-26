<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllStoresResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'profile_photo' => $this->profile_photo,
            'full_phone'    => $this->full_phone,
            'role_id'       => $this->role_id,
            'reviews'       => $this->store?->reviews_avg_review ?? 0,
            'orders'        => $this->store?->orders_count,
            'products'      => $this->store?->products_count,
            'location'      => $this->store?->locations ?? null,
            'city'          => !is_null($this->city) ? new CityResource($this->city) : [],
            'country'       => !is_null($this->country) ? new CountryResource($this->country) : [],
            # TODO::set total_revenue to 0 until handling it
            'total_revenue' => 0,
            'join_date'     => $this->created_at,
        ];
    }
}
