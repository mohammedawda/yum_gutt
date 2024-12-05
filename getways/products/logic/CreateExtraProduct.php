<?php

namespace getways\products\logic;

use Exception;
use getways\products\resources\ExtraProductCategoryDetailsResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateExtraProduct extends ProductManager
{
    public function createProduct($extraProductData): JsonResponse
    {
        $request = $extraProductData['request'];
        $productId = $extraProductData['productId'];
        $validate = $request->validated();
        try{
            DB::beginTransaction();
            $extraProduct = null;
            if (array_key_exists('extra_products', $validate)) {
                $extraProduct = Arr::pull($validate, 'extra_products');
            }
            $extraProductCategory = $validate;
            $extraProductCategory['product_id'] = $productId;
            $extraProductCategoryModel = $this->extraRepository->createProductCategory($extraProductCategory);

            $this->extraRepository->handelExtraProduct(extraProduct: $extraProduct, extraProductCategoryModel: $extraProductCategoryModel);
            DB::commit();
            return sendResponse(status: true, message: __('Extra product created'), data: new ExtraProductCategoryDetailsResource($extraProductCategoryModel));
        } catch (Exception $e) {
            DB::rollBack();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occurred during create this extra product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}
