<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $storeCounts = $this->store()->withCount('followers')->withCount('videos');
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'ProfilePhoto' => $this->profile_photo ?? null,
            'description'  => $this->description ?? null,
            'followers'    => $storeCounts->followers_count ?? 0,
            'vidoes'       => $storeCounts->videos_count ?? 0,
        ];
    }
}
