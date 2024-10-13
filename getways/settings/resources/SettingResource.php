<?php

namespace getways\settings\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
//            'id'                => $this->id,
            'name'              => $this->name,
            'value'             => $this->value,
            'type'              => $this->type,
        ];
    }
}
