<?php

namespace getways\users\models;

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
    public function followers()
    {
        return $this->hasMany(StoreFollower::class, 'store_id');
    }

    public function videos()
    {
        return $this->hasMany(StoreVideo::class, 'store_id');
    }
}
