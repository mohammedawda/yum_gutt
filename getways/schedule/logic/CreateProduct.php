<?php

namespace getways\products\logic;

use Exception;
use getways\products\resources\ProductDetailsResource;
use Illuminate\Support\Facades\DB;

class CreateProduct extends ProductManager
{
    public function createProduct($productData)
    {
        try{
            $this->checkProductKeys($productData);
            $this->appendImageOfProduct($productData);
            $product = $this->productRepository->createProduct($productData);
            return sendResponse(true, __('Product created'), new ProductDetailsResource($product), "");
        } catch (Exception $e) {
            DB::rollBack();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured during create this product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}