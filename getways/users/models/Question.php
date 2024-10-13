<?php

namespace getways\users\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $guarded = [];
    /********************************************* attributes *********************************************/
    public function getQuestionAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->question_ar : $this->question_en;
    }

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }
}
