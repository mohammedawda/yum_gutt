<?php

namespace getways\admins\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminCurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'admin_id' => $this->id,
            'name'     => $this->name,
            'country'  => $this->country->name, 
            'currency' => $this->country->Currency_code,
        ];
    }
}
