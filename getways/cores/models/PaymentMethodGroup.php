<?php

namespace getways\cores\models;

use getways\users\models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodGroup extends Model
{
    use HasFactory;

    protected $table = 'payment_method_groups';
    protected $guarded = [];
    /********************************************* attributes *********************************************/
    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getImageUrlAttribute()
    {
        return ExistsImage($this->image);
    }
    /********************************************* relations *********************************************/
    public function payment_methods(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }
}
