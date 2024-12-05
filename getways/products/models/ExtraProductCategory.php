<?php

namespace getways\products\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExtraProductCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    /********************************* relations *********************************/
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function extraProducts(): HasMany
    {
        return $this->hasMany(ExtraProduct::class);
    }
}
