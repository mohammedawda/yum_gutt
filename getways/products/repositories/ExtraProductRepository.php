<?php

namespace getways\products\repositories;

use getways\products\models\ExtraProduct;
use getways\products\models\ExtraProductCategory;
use Illuminate\Support\Arr;

class ExtraProductRepository
{

    public function findExtraProductCategory($product,$id)
    {
        return $product->extraProductCategory()->find($id);
    }
    public function findExtraProduct($product,$id)
    {
        return $product->extraProducts()->find($id);
    }

    public function createProductCategory($weightData)
    {
        return ExtraProductCategory::create($weightData);
    }

    public function updateProductByObject($product, $update)
    {
        return $product->update($update);
    }

    public function deleteProductByObject($product)
    {
        return $product->delete();
    }

    public function Menu($filter, $with = [])
    {
        $products = ExtraProduct::StoreProducts();
        return $this->filterMenu($products, $filter, $with);

    }

    public function filterMenu($prepared, $filter, $with = [])
    {
        return getTakedPreparedCollection(
            $prepared
            ->when(!empty($filter['search']), function($query) use($filter) {
                $query->where('name', 'like', '%' . $filter['category_id'] . '%');
            })
            ->when(!empty($filter['category_id']), function($query) use($filter) {
                $query->where('category_id', $filter['category_id']);
            })
            ->with($with), $filter);
    }

    public function handelExtraProduct($extraProduct, $extraProductCategoryModel): void
    {
        foreach ($extraProduct as $product) {
            $this->appendImageOfProduct($product);
            $extraProductCategoryModel->extraProducts()->create($product);
        }
    }
    protected function appendImageOfProduct(&$product): void
    {
        if (array_key_exists('image', $product) && !is_null($product['image'])) {
            $image = Arr::pull($product, 'image');
            $product['image'] = upload($image, 'extra_product_images');
        }
    }

}
