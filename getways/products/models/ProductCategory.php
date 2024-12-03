<?php

namespace getways\products\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ProductCategory extends Model
{
    use SoftDeletes;
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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
