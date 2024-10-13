<?php

namespace getways\users\resources;

use App\Support\Traits\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'full_phone'        => $this->phone,
            'country_code'      => $this->country_code,
            'nationalId'      => $this->nationalId,
            'wallet'            => $this->wallet,
            'currency'          => __($this->country->Currency_code),
            'status'            => str($this->status),
            'block'             => str($this->block),
            'block_reason'      => str($this->block_reason),
            'city'              => new CityResource($this->city),
            'country'           => new CountryResource($this->country),
            'wallet_actions'    =>  WalletMovementResource::collection($this->wallets),
        ];
    }
}
