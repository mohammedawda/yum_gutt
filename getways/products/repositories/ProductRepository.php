<?php

namespace getways\products\repositories;

use getways\products\models\Product;

class ProductRepository
{

    public function findProduct($id)
    {
        return Product::find($id);
    }

    public function createProduct($weightData)
    {
        return Product::create($weightData);
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
        $products = Product::StoreProducts();
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
}
