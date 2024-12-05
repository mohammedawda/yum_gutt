<?php

namespace getways\products\logic;

use Exception;
use getways\products\resources\ExtraProductCategoryResource;
use getways\products\resources\ExtraProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ExtraProductUpdate extends ProductManager
{
    public function extraProductCategory($extraProductCategoryData): JsonResponse
    {
        $request = $extraProductCategoryData['request'];
        $productId = $extraProductCategoryData['productId'];
        $extraProductCategoryId = $extraProductCategoryData['categoryId'];
        $validate = $request->validated();
        try{
            $extraProductCategoryModel = $this->checkExtraProductCategoryExistance(productId: $productId,extraProductCategoryId: $extraProductCategoryId);
            $extraProductCategoryModel->update($validate);
            return sendResponse(status: true, message: __('Extra product category updated'), data:  new ExtraProductCategoryResource($extraProductCategoryModel));
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
        $request = $extraProductData['request'];
        $productId = $extraProductData['productId'];
        $extraProductCategoryId = $extraProductData['categoryId'];
        $extraProductId = $extraProductData['extraProduct_id'];
        $validate = $request->validated();
        try{
            $extraProductModel = $this->checkExtraProductExistance(
                productId: $productId,
                extraProductCategoryId: $extraProductCategoryId,
                extraProductId: $extraProductId
            );
            $this->updateImageOfProduct(oldObject: $extraProductModel,productData: $validate, dir:'extra_product_images');
            $extraProductModel->update($validate);
            return sendResponse(status: true, message: __('Extra product created'), data:  new ExtraProductResource($extraProductModel));
        } catch (Exception $e) {
            DB::rollBack();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occurred during create this extra product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}
