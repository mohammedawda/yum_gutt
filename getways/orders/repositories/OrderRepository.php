<?php

namespace getways\orders\repositories;

use getways\orders\models\Order;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{
    public function ordersToDeliver($filter, $select = [], $with = [])
    {
        return getTakedPreparedCollection(Order::OrderCountry()
        ->where('store_id', Auth::id())
        ->where('delivery_status', Order::DELIVERY_STATUS['deliverd'])
        ->select($select)
        ->with($with)
        , $filter);
    }

    public function storeOrders($filter, $select = [], $with = [])
    {
        return getTakedPreparedCollection(Order::OrderCountry()
        ->where('store_id', Auth::id())
        ->when(!empty($filter['search']), function($query) use($filter) {
            $query->where('order_code', 'like', '%' . $filter['search'] . '%');
        })
        ->select($select)
        ->with($with)
        , $filter);
    }
}