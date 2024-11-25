<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'description'           => $this->description ?? null,
            'nationalId_photo_type' => $this->nationalId_photo_type,
            'national_id'           => $this->national_id,
            'national_id_photo'     => $this->national_id_photo_url,
        ];
    }
}
