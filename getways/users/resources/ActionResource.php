<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'by'   => $this->action_by ? ['id' => $this->actionByAdmin?->id, 'name' => $this->actionByAdmin?->name] : "",
            'date' => $this->action_at ? $this->action_at->toFormattedDateString() : "",
            'time' => $this->action_at ? $this->action_at->format('h:i A') : "",
        ];
    }
}
