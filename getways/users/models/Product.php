<?php

namespace getways\users\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $guarded = [];
    /********************************* accessores *********************************/
    public function getImageAttribute()
    {
        return !is_null($this->image) ? GetFile(FileDir('product_images').$this->national_id_photo) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return !is_null($value) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }
    /*********************************** scopes ***********************************/
    public function scopeStoreProducts($query)
    {
        return $query->where('store_id', Auth::id());
    }
    /********************************* relations *********************************/
    public function country()
    {
        // return $this->belongsTo(Country::class, 'country_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
