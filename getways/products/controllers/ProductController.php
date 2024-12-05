<?php

namespace getways\products\controllers;

use App\Http\Controllers\Controller;
use getways\products\requests\CreateProductRequest;
use getways\products\requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allSizes(Request $request)
    {
        return loadGetway('products')->allSizes($request->all());
    }
    public function allCategory(Request $request)
    {
        return loadGetway('products')->allCategory($request->all());
    }
    public function createProduct(CreateProductRequest $request)
    {
        return loadGetway('products')->createProduct($request->validated());
    }

    public function updateProduct($productId, UpdateProductRequest $request)
    {
        return loadGetway('products')->updateProduct($productId, $request->validated());
    }

    public function menu(Request $request)
    {
        return loadGetway('products')->menu($request->all());
    }

    public function findProduct($productId)
    {
        return loadGetway('products')->findProduct($productId);
    }

    public function deleteProduct($productId)
    {
        return loadGetway('products')->deleteProduct($productId);
    }
}
