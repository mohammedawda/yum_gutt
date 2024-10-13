<?php

namespace getways\users\resources;

use getways\users\models\Branch;
use getways\users\models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAnswerResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data = [
            'id'                => $this->id,
            'question'          => new QuestionResource($this->question),
        ];
        if ($request->route()->getName() != "admin_show_user") {
            $data['user'] = new UserResource($this->user);
        }
        if ($this->question_type == 'branches'){
            $data['answer'] = Branch::find($this->answer)?->name ?? "";
        }else{
            $data['answer'] = $this->answer;
        }
        return $data;
    }
}
