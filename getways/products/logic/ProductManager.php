<?php

namespace getways\products\logic;

use Exception;
use getways\products\repositories\ProductRepository;

class ProductManager
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    protected function checkProductKeys($productData)
    {
        if(!array_key_exists('small_price', $productData) && !array_key_exists('medium_price', $productData) && !array_key_exists('large_price', $productData)) {
            throw new Exception(('Missed product price'), 400);
        }
    }

    protected function appendImageOfProduct(&$productData)
    {
        if (array_key_exists('image', $productData) && !is_null($productData['image'])) {
            $productData['image'] = upload($productData['image'], 'product_images');
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