<?php

namespace getways\products\controllers;

use App\Http\Controllers\Controller;
use getways\products\requests\CreateExtraProductRequest;
use getways\products\requests\UpdateExtraProductCategoryRequest;
use getways\products\requests\UpdateExtraProductRequest;
use Illuminate\Http\Request;

class ExtraProductController extends Controller
{
    public function create(CreateExtraProductRequest $request,$productId)
    {
        $data = [
            'request' => $request,
            'productId'=>$productId
        ];
        return loadGetway('products')->createExtraProduct($data);
    }

    public function updateExtraProductCategory($productId,$categoryId, UpdateExtraProductCategoryRequest $request)
    {
        $data = [
            'request' => $request,
            'productId'=>$productId,
            'categoryId'=>$categoryId
        ];
        return loadGetway('products')->updateExtraProductCategory($data);
    }
    public function updateExtraProduct($productId,$categoryId,$extraProduct_id, UpdateExtraProductRequest $request)
    {
        $data = [
            'request' => $request,
            'productId'=>$productId,
            'categoryId'=>$categoryId,
            'extraProduct_id'=>$extraProduct_id,
        ];
        return loadGetway('products')->updateExtraProduct($data);
    }

    public function deleteExtraProductCategory($productId,$categoryId, Request $request)
    {
        $data = [
            'request' => $request,
            'productId'=>$productId,
            'categoryId'=>$categoryId
        ];
        return loadGetway('products')->deleteExtraProductCategory($data);
    }
    public function deleteExtraProduct($productId,$categoryId,$extraProduct_id, Request $request)
    {
        $data = [
            'request' => $request,
            'productId'=>$productId,
            'categoryId'=>$categoryId,
            'extraProduct_id'=>$extraProduct_id,
        ];
        return loadGetway('products')->deleteExtraProduct($data);
    }

    public function allExtraProductCategory($productId)
    {
        return loadGetway('products')->allExtraProductCategory($productId);
    }

    public function extraProduct($productId,$categoryId)
    {
        $data = [
            'productId'=>$productId,
            'extraProductCategoryId'=>$categoryId
        ];
        return loadGetway('products')->extraProduct($data);
    }

    public function deleteProduct($productId)
    {
        return loadGetway('products')->deleteProduct($productId);
    }
}
