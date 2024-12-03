<?php

namespace getways\products\logic;

use Exception;
use getways\products\repositories\ProductRepository;
use Illuminate\Support\Arr;

class ProductManager
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    protected function handelPriceSizeProduct($data,$product): void
    {
        $sizesData = collect($data)->mapWithKeys(function ($item) {
            return [$item['id'] => ['price' => $item['price']]];
        })->toArray();
        $product->sizes()->sync($sizesData);
    }

    protected function appendImageOfProduct(&$productData)
    {
        if (array_key_exists('image', $productData) && !is_null($productData['image'])) {
            $image = Arr::pull($productData, 'image');
            $productData['image'] = upload($image, 'product_images');
        }
    }

    protected function checkProductExistance($productId)
    {
        $product = $this->productRepository->findProduct($productId);
        if($product) {
            return $product;
        }
        throw new Exception(__('Product not found'), 404);
    }

    protected function updateImageOfProduct($oldObject, &$productData)
    {
        if (array_key_exists('image', $productData) && !is_null($productData['image'])) {
            if(!is_null($oldObject->image)) {
                $oldImage = fileExists(FileDir('product_models'), $oldObject->image)
                ? FileDir('product_models').$oldObject->image : false;
                if($oldImage) {
                    unlinkFile($oldImage);
                }
            }
            $productData['image'] = upload($productData['image'], 'product_models');
        }
    }
}
