<?php

namespace getways\products\logic;

use Exception;

class ProductDestroy extends ProductManager
{
    public function deleteProduct($productId)
    {
        try{
            $product = $this->checkProductExistance($productId);
            $this->productRepository->deleteProductByObject($product);
            return sendResponse(true, __('Product deleted'), "");
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured during delete this product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}