<?php

namespace getways\products\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function getImageUrlAttribute()
    {
        return !is_null($this->image) ? GetFile(FileDir('product_images').$this->image) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return !is_null($value) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }
    /*********************************** scopes ***********************************/
    public function scopeStoreProducts($query)
    {
        return $query->where('store_id', Auth::user()->store?->id);
    }
    /********************************* relations *********************************/
    public function country()
    {
        // return $this->belongsTo(Country::class, 'country_id');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class)->withPivot('price')->withTimestamps();
    }
    public function extraProductCategory(): HasMany
    {
        return $this->hasMany(ExtraProductCategory::class);
    }
}
