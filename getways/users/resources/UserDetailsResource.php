<?php

namespace getways\users\resources;

use getways\users\models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $question_count = Question::where('country_id',$this->country_id)->count();
        return [
            'id'                            => $this->id,
            'name'                          => $this->name,
            'email'                         => $this->email,
            'full_phone'                    => $this->full_phone,
            'phone'                         => $this->phone,
            'country_code'                  => $this->country_code,
            'wallet'                        => str($this->wallet),
            'fcm'                           => $this->fcm,
            'created_at'                    => $this->created_at->toFormattedDateString(),
            'status'                        => str($this->status),
            'block'                         => str($this->block),
            'block_reason'                  => str($this->block_reason),
            'nationalId_photo_type'         => str($this->nationalId_photo_type),
            'nationalId_photo'              => $this->nationalId_photo_url,
            'nationalId'                    => $this->nationalId,
            'total_question_count'          => $question_count,
            'user_answer_question_count'    =>count($this->answers),
            'cambain'                       => [
                'id'=>$this->cambain_id,
                'name'=>'test'
            ],
            'city'                          => new CityResource($this->city),
            'answers'                       =>  UserAnswerResource::collection($this->answers),
            'action' => new ActionResource($this),

        ];
    }
}
