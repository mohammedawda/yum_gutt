<?php

namespace getways\products\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExtraProduct extends Model
{
    use HasFactory;
    protected $guarded = [];
    /********************************* accessores *********************************/
    public function getImageUrlAttribute()
    {
        return !is_null($this->image) ? GetFile(FileDir('extra_product_images').$this->image) : null;
    }

    /********************************* relations *********************************/
    public function extraProductCategory(): BelongsToMany
    {
        return $this->belongsToMany(ExtraProductCategory::class);
    }
}
