<?php

namespace getways\orders\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    const DELIVERY_STATUS = [
        'pending'     => 1,
        'prepared'    => 2,
        'in_progress' => 3,
        'deliverd'    => 4,
    ];
    /********************************************* accessors *********************************************/
    public function getCreatedAtAttribute($value)
    {
        return !is_null($value) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }
    /********************************************* scopes *********************************************/
    public function scopeOrderCountry()
    {
        //
    }
    /********************************************* relations *********************************************/
    public function cart()
    {
        return $this->hasMany(Cart::class, 'order_id');
    }
}
