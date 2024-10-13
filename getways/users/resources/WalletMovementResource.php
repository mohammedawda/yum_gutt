<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletMovementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'value'             => $this->value,
            'desc'              => $this->desc,
            'create_at'         => $this->created_at->toFormattedDateString(),
            'updated_at'        => $this->updated_at->toFormattedDateString(),
            'type'              => $this->typeString(),
        ];
    }
}
