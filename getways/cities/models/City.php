<?php

namespace getways\cities\models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class City extends Model
{
    use HasTranslations;

    protected $guarded   = [];
    public $translatable = ['name'];
    /********************************************* attributes *********************************************/
    public function getNameAttribute()
    {
        return $this->getTranslations('name')[app()->getLocale()] ?? '';
    }
}
