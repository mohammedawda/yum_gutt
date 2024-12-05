<?php

namespace getways\products\logic;

use Exception;
use getways\products\resources\ExtraProductCategoryResource;
use getways\products\resources\ExtraProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ExtraProductIndex extends ProductManager
{
    public function extraProductCategory($productId): JsonResponse
    {
        try{
            $product = $this->checkProductExistance($productId);
            return sendResponse(status: true, message: __('Extra product created'), data:  ExtraProductCategoryResource::collection($product->extraProductCategory));
        } catch (Exception $e) {
            DB::rollBack();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occurred during create this extra product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
    public function extraProduct($extraProductData): JsonResponse
    {
        $productId = $extraProductData['productId'];
        $extraProductCategoryId = $extraProductData['extraProductCategoryId'];
        try{
            $extraProductCategoryModel = $this->checkExtraProductCategoryExistance(productId: $productId,extraProductCategoryId: $extraProductCategoryId);
            return sendResponse(status: true, message: __('Extra product created'), data:  ExtraProductResource::collection($extraProductCategoryModel->extraProducts));
        } catch (Exception $e) {
            DB::rollBack();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occurred during create this extra product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}
