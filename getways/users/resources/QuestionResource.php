<?php

namespace getways\users\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id'                => $this->id,
            'question'          => $this->question,
            'type'              => $this->type,
            'status'              => $this->status,
        ];
        if ($this->type != 'branches'){
            $data['answers'] = QuestionAnswerResource::collection($this->answers);
        }
        return $data;
    }
}
