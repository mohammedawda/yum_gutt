<?php

namespace getways\orders\controllers;

use Illuminate\Http\Request;

class OrdersController
{
    public function ordersToDeliver(Request $request)
    {
        return loadGetway('orders')->ordersToDeliver($request->all());
    }

    public function storeOrders(Request $request)
    {
        return loadGetway('orders')->storeOrders($request->all());
    }
}