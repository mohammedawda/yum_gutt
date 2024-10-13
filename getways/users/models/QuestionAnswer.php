<?php

namespace getways\users\models;

use getways\settings\models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getBodyLangAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->body_ar : $this->body;
    }
    /********************************************* relations *********************************************/
    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
