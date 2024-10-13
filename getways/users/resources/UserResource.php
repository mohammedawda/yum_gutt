<?php

namespace getways\users\resources;

use getways\users\models\Question;
use getways\users\models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'full_phone'   => $this->full_phone,
            'phone'        => $this->phone,
            'country_code' => $this->country_code,
            'city'         => new CityResource($this->city),
            'wallet'       => str($this->wallet),
            'fcm'          => $this->fcm,
            'created_at'   => $this->created_at->toFormattedDateString(),
            'status'       => str($this->status),
            'block'        => str($this->block),
            'block_reason' => str($this->block_reason),
            'action'       => new ActionResource($this),
        ];
    }
}
