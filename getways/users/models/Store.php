<?php

namespace getways\users\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;
    const NATIONAL_ID_PHOTO_TYPE = [
        'passport'    => 1 ,
        'national_id' => 2,
    ];
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

    public function storeReels()
    {
        return $this->hasMany(Reel::class, 'store_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'store_id');
    }

    public function reels()
    {
        return $this->hasMany(Reel::class, 'owner_id');
    }
}
