<?php

namespace getways\products\logic;

use Exception;
use getways\products\resources\ProductDetailsResource;

class ProductDetails extends ProductManager
{
    public function findProduct($productId)
    {
        try{
            $product = $this->checkProductExistance($productId);
            return sendResponse(true, __('Product details'), new ProductDetailsResource($product));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured during display product details, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}