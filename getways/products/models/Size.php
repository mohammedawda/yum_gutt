<?php

namespace getways\products\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class Size extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $guarded = [];
    use HasTranslations;
    protected array $translatable = ['name'];
    /********************************* accessores *********************************/

    public function getCreatedAtAttribute($value)
    {
        return !is_null($value) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }
    /*********************************** scopes ***********************************/
    /********************************* relations *********************************/

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('price')->withTimestamps();
    }
}
