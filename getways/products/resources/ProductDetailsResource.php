<?php

namespace getways\products\resources;

use getways\products\models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ProductDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $sizesNotRelated = Size::whereDoesntHave('products', function ($query) {
            $query->where('products.id', $this->id);
        })->get();
        return [
            'id'           => (int)$this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'image'        => $this->image_url,
            'discount'     => (string)$this->discount,
            'main_price'   => (string)$this->main_price,
            'category'     => new ProductCategoryResource($this->category),
            'sizes'        => ProductSizesResource::collection($this->sizes),
            'other_sizes'  => SizeDetailsResource::collection($sizesNotRelated),
            'extra_product_category'  => ExtraProductCategoryDetailsResource::collection($this->extraProductCategory),
        ];
    }
}
