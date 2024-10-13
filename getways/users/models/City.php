<?php

namespace getways\users\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];
    /********************************************* attributes *********************************************/
    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getImageUrlAttribute()
    {
        return ExistsImage($this->image);
    }
}
