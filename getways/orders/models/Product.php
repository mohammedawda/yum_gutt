<?php

namespace getways\orders\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable = ['name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $guarded = [];

    /********************************************* accessores *********************************************/
    public function getNameAttribute()
    {
        return $this->name->{app()->getLocale()} ?? '';
    }
}
