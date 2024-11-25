<?php

namespace getways\products\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $guarded = [];
    /********************************************* relations *********************************************/

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }
}
