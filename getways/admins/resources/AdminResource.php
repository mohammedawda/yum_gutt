<?php

namespace getways\admins\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'country_code'      => $this->country_code,
            'status'            => str($this->status),
            'role'              => $this->getRoleNames()->first(),
        ];
    }
}
