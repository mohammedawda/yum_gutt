<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'wallet'            => $this->wallet,
            'currency'          => __($this->country->Currency_code),
            'wallet_actions'    => WalletMovementResource::collection($this->wallets->sortByDesc('id')),
        ];
    }
}
