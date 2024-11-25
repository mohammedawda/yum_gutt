<?php

namespace getways\schedule\controllers;

use App\Http\Controllers\Controller;
use getways\products\requests\CreateScheduleRequest;
use getways\products\requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function createSchedule(CreateScheduleRequest $request)
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