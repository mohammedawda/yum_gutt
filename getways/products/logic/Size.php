<?php

namespace getways\products\logic;

use Exception;
use getways\products\models\ProductCategory;
use getways\products\resources\ProductCategoryResource;
use getways\products\resources\SizeDetailsResource;
use getways\products\models\Size as SizeModel;
use Illuminate\Support\Facades\Auth;

class Size extends ProductManager
{
    public function allSizes($productData)
    {
        try{
            $sizes = SizeModel::all();

            return sendResponse(status: true, message: __('All sizes'), data: SizeDetailsResource::collection($sizes));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured during create this product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
    public function allCategory($productData)
    {
        try{
            $category = ProductCategory::where('category_id',Auth::user()->store?->category_id)->get();

            return sendResponse(status: true, message: __('All sizes'), data: ProductCategoryResource::collection($category));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured during create this product, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}
