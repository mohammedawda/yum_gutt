<?php

namespace getways\products\logic;

use Exception;
use getways\products\repositories\ExtraProductRepository;
use getways\products\repositories\ProductRepository;
use Illuminate\Support\Arr;

class ProductManager
{
    public ExtraProductRepository $extraRepository ;
    public function __construct(protected ProductRepository $productRepository)
    {
        $this->extraRepository = new ExtraProductRepository();
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

    protected function checkExtraProductCategoryExistance($productId,$extraProductCategoryId)
    {
        $product = $this->checkProductExistance($productId);
        $extraProductCategoryModel = $this->extraRepository->findExtraProductCategory(product: $product,id: $extraProductCategoryId);
        if($extraProductCategoryModel) {
            return $extraProductCategoryModel;
        }
        throw new Exception(__('Extra product category not found'), 404);
    }

    protected function checkExtraProductExistance($productId,$extraProductCategoryId,$extraProductId)
    {
        $extraProductCategoryModel = $this->checkExtraProductCategoryExistance($productId,$extraProductCategoryId);
        $extraProductModel = $this->extraRepository->findExtraProduct(product: $extraProductCategoryModel,id: $extraProductId);
        if($extraProductModel) {
            return $extraProductModel;
        }
        throw new Exception(__('Extra product not found'), 404);
    }

    protected function updateImageOfProduct($oldObject, &$productData, $dir)
    {
        if (array_key_exists('image', $productData) && !is_null($productData['image'])) {
            if(!is_null($oldObject->image)) {
                $oldImage = fileExists(FileDir($dir), $oldObject->image)
                ? FileDir($dir).$oldObject->image : false;
                if($oldImage) {
                    unlinkFile($oldImage);
                }
            }
            $image = Arr::pull($productData, 'image');
            $productData['image'] = upload($image, $dir);
        }
    }
}
