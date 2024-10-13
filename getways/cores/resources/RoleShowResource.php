<?php

namespace getways\cores\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'permissions'     => PermissionResource::collection($this->permissions),
        ];
    }
}
