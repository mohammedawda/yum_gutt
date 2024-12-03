<?php

namespace getways\products\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    use HasTranslations;
    protected array $translatable = ['name'];
}
