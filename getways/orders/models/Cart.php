<?php

namespace getways\orders\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    
    /********************************************* relations *********************************************/
    public function product()
    {
        return $this->belongsTo(Cart::class);
    }
}
