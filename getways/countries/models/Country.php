<?php

namespace getways\countries\models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Country extends Model
{
    use HasTranslations;
    protected $guarded   = [];
    public $translatable = ['name'];
    /********************************************* attributes *********************************************/
    public function getNameAttribute()
    {
        return $this->getTranslations('name')[app()->getLocale()] ?? '';
    }

    public function getImageUrlAttribute()
    {
        return ExistsImage($this->image);
    }
}
