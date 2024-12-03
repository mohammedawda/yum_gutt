<?php

namespace getways\products\logic;

use Exception;
use getways\products\resources\ProductDetailsResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProduct extends ProductManager
{
    public function createProduct($productData)
    {
        try{
            DB::beginTransaction();
            $sizesPrice = null;
            if (array_key_exists('sizes', $productData)) {
                $sizesPrice = Arr::pull($productData, 'sizes');
            }
            $this->appendImageOfProduct($productData);
            $productData['store_id'] = Auth::user()?->store?->id;
            $product = $this->productRepository->createProduct($productData);
            $this->handelPriceSizeProduct(data: $sizesPrice,product: $product);
            DB::commit();
            return sendResponse(status: true, message: __('Product created'), data: new ProductDetailsResource($product));
        } catch (Exception $e) {
            DB::rollBack();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occurred during create this product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}
