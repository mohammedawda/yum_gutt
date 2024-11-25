<?php

namespace getways\products\logic;

use Exception;
use getways\products\resources\ProductDetailsResource;
use Illuminate\Support\Facades\DB;

class UpdateProduct extends ProductManager
{
    public function updateProduct($productId, $productData)
    {
        try{
            $product = $this->checkProductExistance($productId);
            $this->updateImageOfProduct($product, $productData);
            $this->productRepository->updateProductByObject($product, $productData);
            return sendResponse(true, __('Product updated'), new ProductDetailsResource($product));
        } catch (Exception $e) {
            DB::rollBack();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured during update this product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}